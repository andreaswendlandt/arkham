#!/bin/bash

for i in {1..10}; do
    for j in {1..10}; do
        printf "%s$j*$i=$((i*j))\t"
    done
    echo ""
done
