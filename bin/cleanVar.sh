#!/bin/bash

source "$(cd `dirname $0` && pwd)/shelly.sh"

# load config file
source $CONFIGFILE

runAsRoot

for d in $ROOT/var/*/ ; do
  if [ -d "$d" ]; then
		# show
		echo "$d"
		find "$d" -xdev -mindepth 1

		# delete
		find "$d" -xdev -mindepth 1 -delete
  fi
done
