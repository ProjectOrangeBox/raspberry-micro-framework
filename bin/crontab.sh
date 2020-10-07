#!/bin/bash

source "$(cd `dirname $0` && pwd)/shelly.sh"

# load config file
source $CONFIGFILE

crontabInit

#runScript sendEmail blocking
