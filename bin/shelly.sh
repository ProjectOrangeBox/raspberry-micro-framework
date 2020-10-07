#!/bin/bash

function crontabInit() {
	# find index.php based on root and public directory
	setupPHP

	# what is the EXE we are calling with the provided options
	export EXE="$PHP $INDEXFILE"

	# these should be set in the config.ini file
	checkIfSet MAXLOGAGE
	checkIfSet MAXLOCKAGE

	println "---- $SCRIPTFILE ----"

	cleanDirectory "$LOGDIRECTORY" "$MAXLOGAGE"
}

function setupPHP() {
	println "Setting up PHP and index.php entry point."

	#auto locate php
	export PHP=$(which php)

	# find index.php based on root and public directory
	findIndex

	# what is the EXE we are calling with the provided options
	export EXE="$PHP $INDEXFILE"

	println "PHP $PHP"

	println "Index File $INDEXFILE"

	println "Execute $EXE"
}

function runScript() {
	# test to make sure the required directories are setup
	directoryRequired "$VARDIRECTORY"
	directoryRequired "$TEMPDIRECTORY"
	directoryRequired "$LOGDIRECTORY"

	local ENDPOINT=$1
	local BLOCKING=$2

	# make file safe name
	local FILE="$( echo $1 | sed s:/:_:g )"
	local DATETIME="$(date '+%Y-%m-%d')"

	local LOCKFILE="$TEMPDIRECTORY/$FILE.lock.txt"
	local SCRIPTLOGFILE="$LOGDIRECTORY/$DATETIME-$FILE.log"
	local EXEENDPOINT="$EXE $ENDPOINT"

	createLockFile "$LOCKFILE" "$ENDPOINT" "$MAXLOCKAGE"

	if [ "$?" == "1" ]; then
		# locked so exit runScript()
		return 1
	fi

	if [ "$BLOCKING" == "blocking" ]; then
		# in log file
		println "$ENDPOINT Started Blocking" true

		# Execute & clean up not in background
		($EXEENDPOINT >> $SCRIPTLOGFILE ; removeLockFile "$LOCKFILE" "$ENDPOINT")
	else
		println "$ENDPOINT Started in Background" true

		# Execute & clean up in background
		($EXEENDPOINT >> $SCRIPTLOGFILE ; removeLockFile "$LOCKFILE" "$ENDPOINT")  &
	fi

	return 0
}

function durationToSeconds() {
  set -f

	normalize () { echo $1 | tr '[:upper:]' '[:lower:]' | tr -d "\"\\\'" | sed 's/ *y\(ear\)\{0,1\} */y /g; s/ *d\(ay\)\{0,1\} */d /g; s/ *h\(our\)\{0,1\} */h /g; s/ *m\(in\(ute\)\{0,1\}\)\{0,1\} */m /g; s/ *s\(ec\(ond\)\{0,1\}\)\{0,1\} */s /g; s/\([ydhms]\)s/\1/g'; }

	local value=$(normalize "$1")
  local fallback=$(normalize "$2")

  echo $value | grep -v '^[-+*/0-9ydhms ]\{0,30\}$' > /dev/null 2>&1
  if [ $? -eq 0 ]; then
    >&2 echo Invalid duration pattern \"$value\"
  else
    if [ "$value" = "" ]; then
      [ "$fallback" != "" ] && durationToSeconds "$fallback"
    else
      sedtmpl () { echo "s/\([0-9]\+\)$1/(0\1 * $2)/g;"; }
      local template="$(sedtmpl '\( \|$\)' 1) $(sedtmpl y '365 * 86400') $(sedtmpl d 86400) $(sedtmpl h 3600) $(sedtmpl m 60) $(sedtmpl s 1) s/) *(/) + (/g;"
      echo $value | sed "$template" | bc
    fi
  fi

	set +f
}

function println() {
	local MSG="$(/bin/date) $1"

	if test -n "$TERM"; then
		echo -e $MSG
	fi

	if [ -d "$LOGDIRECTORY" ]; then
		if test -n "$SHELLYLOGFILE"; then
			
			echo -e $MSG | sed 's/\x1b\[[0-9;]*[a-zA-Z]//g' >> $SHELLYLOGFILE
		fi
	fi
}

function cleanDirectory() {
	local DIRECTORY=$1
	local SECONDS=$(durationToSeconds "$2")
	local FILES=$DIRECTORY/*

	if [ ! -d "$DIRECTORY" ]; then
		println "\033[0;31mCannot clean the directory $DIRECTORY because it was not found.\033[0m"
	else
		println "Cleaning the directory $DIRECTORY of files older than $2"

		for F in $FILES
			do
				if [ `stat --format=%Y $F` -le $(( `date +%s` - $SECONDS )) ]; then
					println "$F removed"

					rm -f $F
				fi;
		done
	fi;
}

function cleanFile() {
	local FILE=$1
	local SECONDS=$(durationToSeconds "$2")

	if test -f "$FILE"; then
		if [ `stat --format=%Y $FILE` -le $(( `date +%s` - $SECONDS )) ]; then
			println "Removing the file $FILE which is older than $2."

			rm -f $FILE
		fi
	fi
}

function checkIfSet() {
	local testVar="$1"
	local default="$2"

	if [ -z "${!testVar}" ]; then
		if [ -z "$default" ]; then
			println "\033[0;31mVariable $1 not set and is required.\033[0m"
			exit 1
		else
			export ${testVar}=\""$default"\"
		fi;
	fi;
}

function createLockFile() {
	local LOCKFILE="$1"
	local ENDPOINT="$2"
	local MAXLOCKAGE="$3"

	# delete the lock file if it's more than X old
	cleanFile "$LOCKFILE" "$MAXLOCKAGE"

	# Lock file if already exists and return 1 (fail)
	if [ -f "$LOCKFILE" ]; then
		# file & screen
		println "$ENDPOINT Locked on $( cat "$LOCKFILE" )" true

		return 1 # failure
	fi

	# Create the lock file
	echo $(date) >> "$LOCKFILE"

	# file & screen
	println "$ENDPOINT Lock file created" true

	return 0 # success
}

function removeLockFile() {
	local LOCKFILE="$1"
	local ENDPOINT="$2"

	if [ -f "$LOCKFILE" ]; then
		local SECONDS=$(($(date +%s) - $(date +%s -r $LOCKFILE)))

		rm $LOCKFILE;

		println "$ENDPOINT Ended. Elapsed time $(displayHumanTime $SECONDS)" true
		println "$ENDPOINT Lock File Removed" true
	else
		println "$ENDPOINT Ended." true
		println "$ENDPOINT Lock File Missing" true
	fi
}

function displayHumanTime() {
  local T=$1
  local D=$((T/60/60/24))
  local H=$((T/60/60%24))
  local M=$((T/60%60))
  local S=$((T%60))

  (( $D > 0 )) && printf '%d days ' $D
  (( $H > 0 )) && printf '%d hours ' $H
  (( $M > 0 )) && printf '%d minutes ' $M
  (( $D > 0 || $H > 0 || $M > 0 )) && printf 'and '

	printf '%d seconds\n' $S
}

function directoryRequired() {
	if [ ! -d "$1" ]; then
		println "\033[0;31mThe directory $1 does not exist.\033[0m"
		exit;
	fi
}

function fileRequired() {
	if [ -f "$1" ]; then
		:
	else
		println "\033[0;31mThe file $1 does not exist.\033[0m"
		exit
	fi
}

function runAsRoot() {
	if [ "$EUID" -ne 0 ]; then
		println "\033[0;31mPlease run using sudo or as root.\033[0m"
		exit
	fi
}

function safeMakeDirectory() {
	if [ ! -d "$ROOT$1" ]; then
		println "Making directory $1"
		mkdir $ROOT$1
	else
		println "Directory $1 already exists."
	fi
}

function groupExists() {
	# check if group is valid group
	if grep -q "$1:" /etc/group; then
		:
	else
		println "\033[0;31mThe Group $1 does not exist.\033[0m"
		exit
	fi
}

function ownerExists() {
	# check if owner is valid user
	if grep -q "$1:" /etc/passwd; then
		:
	else
		println "\033[0;31mThe Owner $1 does not exist.\033[0m"
		exit
	fi
}

function findIndex() {
	local PATH="$ROOT$PUBLICDIRECTORY/index.php"

	if [ -f "$PATH" ]; then
		:
	else
		println "\033[0;31mCould not locate index.php at $PATH.\033[0m"
		exit
	fi

	export INDEXFILE="$PATH"
}

function checkForConfig() {
	if [ -f "$1" ]; then
		:
	else
		println "\033[0;31mThe Config File $1 does not exist.\033[0m"
		exit
	fi
}

function rmFiles() {
	local PATH="$ROOT$1"

	echo $PATH
}

function fix() {
	println "Changing $ROOT Directories Mode to 775."
	find $ROOT -type d -exec chmod 775 {} \;

	println "Changing $ROOT Files Mode to 664."
	find $ROOT -type f -exec chmod 664 {} \;

	println "Changing $ROOT Owner to $OWNER."
	find $ROOT -type d -exec chown $OWNER {} \;
	find $ROOT -type f -exec chown $OWNER {} \;

	println "Changing $ROOT Group to $GROUP."
	find $ROOT -type d -exec chgrp $GROUP {} \;
	find $ROOT -type f -exec chgrp $GROUP {} \;

	# Read / Write directory
	println "Adjust $ROOT/var directory to make Read/Writable."
	find "$ROOT/var/" -type d -exec chmod 777 {} \;
	find "$ROOT/var/" -type f -exec chmod 666 {} \;

	# bin shell stuff
	println "Adjust $ROOT/bin Scripts to make executable."
	find "$ROOT/bin/" -type f -iname "*.sh" -exec chmod 777 {} \;
}

function debugShelly() {
	println "Config File: $CONFIGFILE"

	println "Script File: $SCRIPTFILE"

	println "Script DIRECTORY: $SCRIPTDIRECTORY"

	println "Root DIRECTORY: $ROOT"

	println "VAR DIRECTORY: $VARDIRECTORY"

	println "Temp DIRECTORY: $TEMPDIRECTORY"

	println "Log DIRECTORY: $LOGDIRECTORY"

	println "Shelly Log File: $SHELLYLOGFILE"
}

# setup the variables

# where are we?
SCRIPTFILE=$(readlink -f $0)
SCRIPTDIRECTORY=`dirname $SCRIPTFILE`

# Applications root path
ROOT="`dirname $SCRIPTDIRECTORY`"

println "Application Directory $ROOT"

# Read / Writeable's Directory
VARDIRECTORY="$ROOT/var"

# Temp Working Directory
TEMPDIRECTORY="$VARDIRECTORY/tmp"

# Log Directory
LOGDIRECTORY="$VARDIRECTORY/logs"

# where should my println output be sent?
SHELLYLOGFILE="$LOGDIRECTORY/$(date '+%Y-%m-%d')-shelly-$(basename "$0" .sh).log"

# Config file path
CONFIGFILE="$SCRIPTDIRECTORY/config.ini"

# Is the config file there?
checkForConfig $CONFIGFILE
