#!/bin/bash
# author: guerillatux
# desc: simple wrapper script for cronjobs which have piped commands
# desc: it notifies the cronguard server via curl the start-/endtime and the result of a script 
# last modified: 12.08.2018

if [ $# -ne 1 ]; then
    echo "This Script needs 1 Parameter, a Command-Chain"
    echo "Usage: $0 <\"command1|command2|command3\">"
    exit 1
fi

if ! which curl >/dev/null; then
    echo "Error, curl is missing on this system!"
    exit 1
fi

command="$1"
host=$(hostname)
token=$(openssl rand -base64 4 | sed -e 's/==//')
start_time=$(date +%s)
action="start"

curl -X POST -F "token=$token" -F "host=$host" -F "start_time=$start_time" -F "command=$command" -F "action=$action "http://localhost/cron.php

eval "$command; "'pipe=${PIPESTATUS[*]}'
set $pipe

j=1
error=
for i in $*; do
    if [ $i -ne 0 ]; then
        error="$error $j.command"
    fi
    j=$((j+1))
done

result=
if [ -z "$error" ]; then
    result="success"
else
    result="fail"
fi

action="finished"
end_time=$(date +%s)
curl -X POST -F "token=$token" -F "action=$action" -F "end_time=$end_time" -F "result=$result" http://localhost/cron.php
