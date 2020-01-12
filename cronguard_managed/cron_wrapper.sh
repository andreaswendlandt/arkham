#!/bin/bash
# author: guerillatux
# desc: wrapper script for cronjobs
# desc: it notifies the cronguard server via curl about the start-/endtime and the result of whatever it was given to 
# last modified: 12.01.2020

# Check if something was given to execute
if [ $# -ne 1 ]; then
    echo "This Script needs 1 parameter, either a command-chain, a command or a script"
    echo "Usage: $0 <command1|command2|command3>"
    echo "or"
    echo "$0 <command>"
    echo "or"
    echo "$0 <script.sh>"
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

# Include config file
if ! source /opt/cronguard/token.inc.sh 2>/dev/null; then
    echo "Could not include token.inc.sh from /opt/cronguard, the cronjob will be executed but the cronguard server will not contacted"
    echo "Please fix this manually!"
    token_not_present=1
fi

# Checking the prerequisites for contacting the cronguard server
check_prerequisites(){
    if (( $curl_not_present == 0 )) && (( $token_not_present == 0 )); then
        return 0
    else
        return 1
    fi
}

##Fixme
# code for validating the token
##Fixme

# Variables
command="$1"
host=$(hostname)
url="http://localhost/cronguard_managed/cronguard.php"
start_time=$(date +%s)
action="start"

if check_prerequisites; then
    # First curl, adding a new database entry with the starttime
    #curl -X POST -F "token=$token" -F "host=$host" -F "start_time=$start_time" -F "command=$command" -F "action=$action" $url
    echo "execute first curl"
else
    echo "not execute first curl"
fi

# Execute the cron command and save the pipestatus in the variable "pipe"
eval "$command; "'pipe=${PIPESTATUS[*]}'
set $pipe

# Checking the array for errors
j=1
error=
for i in $*; do
    if [ $i -ne 0 ]; then
        error="$error $j.command"
    fi
    j=$((j+1))
done

# Defining the result for the next curl and database entry
result=
if [ -z "$error" ]; then
    result="success"
else
    result="fail"
fi

if check_prerequisites; then
    # Define the Endtime and make the second Curl, modify the above Database Entry
    action="finished"
    end_time=$(date +%s)
    #curl -X POST -F "token=$token" -F "action=$action" -F "end_time=$end_time" -F "result=$result" $url
    echo "execute second curl"
else
    echo "not execute second curl"
fi
