#!/bin/bash

source "$(cd `dirname $0` && pwd)/shelly.sh"

# load config file
source $CONFIGFILE

runAsRoot

println "Config File: $CONFIGFILE"

println "Script File: $SCRIPTFILE"

println "Script DIRECTORY: $SCRIPTDIRECTORY"

println "Root DIRECTORY: $ROOT"

println "VAR DIRECTORY: $VARDIRECTORY"

println "Temp DIRECTORY: $TEMPDIRECTORY"

println "Log DIRECTORY: $LOGDIRECTORY"

println "Shelly Log File: $SHELLYLOGFILE"

# check if owner is valid user
ownerExists $OWNER
println "Owner $OWNER"

# check if group is valid group
groupExists $GROUP
println "Group $GROUP"

# if the script needs to use PHP / your application
setupPHP
