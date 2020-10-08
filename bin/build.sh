#!/bin/bash

source "$(cd `dirname $0` && pwd)/shelly.sh"

# load config file
source $CONFIGFILE

println "Building Folder Structure."
for dir in "${REQUIREDDIRECTORIES[@]}"
do
	safeMakeDirectory $dir
done

if [ ! -d "$ROOT/packages/projectorangebox" ]; then
  println "Checking Out ProjectOrangeBox raspberry-package."
  git clone https://github.com/ProjectOrangeBox/raspberry-package "$ROOT/packages/projectorangebox"
else
  println "\033[0;31mProjectOrangeBox raspberry-package already checked out.\033[0m"
fi;


if [ $(which composer) ]; then
  println "Running Composer Update."
  composer update
else
  println "\033[0;31mCould not locate composer to run update.\033[0m"
fi;

println "Finished."
