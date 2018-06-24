#!/bin/bash
# author: guerillatux
# desc: simple wrapper script for cronjobs which have piped commands
# last modified: 24.6.2018

if [ $# -ne 2 ]; then
    echo "This Script needs 2 Parameters, a Token and a Command-Chain"
    echo "Usage: $0 <ghgf4vl5> <\"command1|command2|command3\">"
    exit 1
fi

token="$1"
command="$2"
url=

#curl ${url}/${token}\;b
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

if [ -z "$error" ]; then
    #curl ${url}/${token}\;e 
    :
else
    echo "Error at the following Command(s): $error"
fi
