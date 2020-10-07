#!/bin/bash

source "$(cd `dirname $0` && pwd)/shelly.sh"

# load config file
source $CONFIGFILE

runAsRoot

# check if owner is valid user
ownerExists $OWNER
println "Owner $OWNER"

# check if group is valid group
groupExists $GROUP
println "Group $GROUP"

# start

println "Building Folder Structure."
for dir in "${REQUIREDDIRECTORIES[@]}"
do
	safeMakeDirectory $dir
done

fix
