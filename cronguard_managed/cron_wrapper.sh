#!/bin/bash
# author: guerillatux
# desc: wrapper script for cronjobs
# desc: it notifies the cronguard server via curl about the start-/endtime and the result of whatever it was given to 
# last modified: 10.01.2020

if [ $# -ne 1 ]; then
    echo "This Script needs 1 Parameter, a Command-Chain"
    echo "Usage: $0 <\"command1|command2|command3\">"
    exit 1
fi

# Variables for executing curl (or not)
curl_not_present=0
token_not_present=0

# Check that curl is present on the system
if ! which curl >/dev/null; then
    echo "Error, curl is missing on this system, the cronjob will be executed but the cronguard server will not contacted"
    echo "Please fix this manually!"
    curl_not_present=1
fi

# Include Config File
if ! source /opt/cronguard/token.inc.sh 2>/dev/null; then
    echo "Could not include token.inc.sh from /opt/cronguard, the cronjob will be executed but the cronguard server will not contacted"
    echo "Please fix this manually!"
    token_not_present=1
fi

##Fixme
# code for validating the token
##Fixme

# Variables
command="$1"
host=$(hostname)
url="http://localhost/cronguard_managed/cronguard.php"
start_time=$(date +%s)
action="start"

if (( $curl_not_present == 0 )) && (( $token_not_present == 0 )); then
    # First curl, adding a new Database Entry with the Starttime
    #curl -X POST -F "token=$token" -F "host=$host" -F "start_time=$start_time" -F "command=$command" -F "action=$action" $url
    echo "execute first curl"
else
    echo "not execute first curl"
fi

# Execute the Cron Command and save the Pipestatus in the Variable "pipe"
eval "$command; "'pipe=${PIPESTATUS[*]}'
set $pipe

# Checking the Array for Errors
j=1
error=
for i in $*; do
    if [ $i -ne 0 ]; then
        error="$error $j.command"
    fi
    j=$((j+1))
done

# Defining the Result for the next Curl and Database Entry
result=
if [ -z "$error" ]; then
    result="success"
else
    result="fail"
fi

if (( $curl_not_present == 0 )) && (( $token_not_present == 0 )); then
    # Define the Endtime and make the second Curl, modify the above Database Entry
    action="finished"
    end_time=$(date +%s)
    #curl -X POST -F "token=$token" -F "action=$action" -F "end_time=$end_time" -F "result=$result" $url
    echo "execute second curl"
else
    echo "not execute second curl"
fi
