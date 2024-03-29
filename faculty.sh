#!/bin/bash
# author: andreaswendlandt
# desc: a (recursive) bash version of the faculty
# last modified: 20240329

read -r -p "enter a number: " num

fac(){
    number=${1}
    if [[ "${number}" == 0 ]]; then
        echo 1
    else
        echo $((number*$(fac $((number-1)))))
    fi
}

fac "${num}"
