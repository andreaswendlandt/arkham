#!/bin/bash
# desc: wrapper script for cronjobs
# desc: part of the cronguard lifecycle
# desc: it notifies the cronguard server via curl about the start-/endtime and the result of whatever it was given to 

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

# Variables
command="$1"
host=$(hostname)
url="http://cronguard.ddns.net/cronguard.php"
url_validate_token="http://cronguard.ddns.net/validate_token_wrapper.php"
start_time=$(date +%s)
action="start"
curl_not_present=0
token_not_present=0
token_not_valid=1
ident=$(openssl rand -hex 3)

# Check that curl is present on the system
if ! which curl >/dev/null; then
    echo "Error, curl is missing on this system, the cronjob will be executed but the cronguard server will not contacted"
    echo "Please fix this manually!"
    curl_not_present=1
fi

# Check that the config file was included and $token has a value
if ! source /opt/cronguard/token.inc.sh 2>/dev/null; then
    echo "Could not include token.inc.sh from /opt/cronguard, the cronjob will be executed but the cronguard server will not contacted"
    echo "Please fix this manually!"
    token_not_present=1
elif [ -z $token ]; then
    echo "The token variable \$token is empty, the cronjob will be executed but the cronguard server will not contacted"
    token_not_present=1
fi

# Check that the given token is a valid one
if (( $curl_not_present == 0)) && (( $token_not_present == 0 )); then
    if [ "$(curl -s -X POST -F "token=$token" $url_validate_token)" == "valid" ]; then
        token_not_valid=0
    elif [ "$(curl -s -X POST -F "token=$token" $url_validate_token)" == "invalid" ]; then
        echo "Your token \"$token\" is not valid and cronguard will not contacted!"
        echo "(the same check will be executed on the server side regardless of this one here)"
        echo "Please generate a new one here: http://cronguard.ddns.net/generate_token.php"
        echo "The cronjob will be executed but the cronguard server will not contacted"
    else
        echo "Could not determine the status of your token \"$token\", please contact andreas.cronguard@gmail.com"
        echo "The cronjob will be executed but the cronguard server will not contacted"
    fi
fi

# Checking the prerequisites for contacting the cronguard server
check_prerequisites(){
    if (( $token_not_valid == 0 )); then
        return 0
    else
        return 1
    fi
}

if check_prerequisites; then
    # First curl, adding a new database entry with the starttime
    curl -X POST -F "ident=$ident" -F "token=$token" -F "host=$host" -F "start_time=$start_time" -F "command=$command" -F "action=$action" $url
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
    # Define the endtime and make the second curl, modify the above database entry
    action="finished"
    end_time=$(date +%s)
    curl -X POST -F "ident=$ident" -F "token=$token" -F "action=$action" -F "end_time=$end_time" -F "result=$result" $url
fi
