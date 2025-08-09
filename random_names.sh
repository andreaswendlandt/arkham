#!/bin/bash

if [[ $# -lt 2 ]]; then
    echo "this script needs at least two arguments"
    echo "usage: $0 frodo sam pippin merri aragorn gandalf gimli boromir legolas"
    echo "aragorn"
    exit 1
fi

names=( "$@" )

rand_num="$(( RANDOM % $# ))"

echo "${names[$rand_num]}"
