#!/bin/bash

for entry in $(echo -e "$(sed -e 's/|/\\n/g' file)"); do 
    if ! [[ $first == *"${entry:0:1}"* ]]; then
        first+=${entry:0:1}
    fi
    if ! [[ $second == *"${entry:1:1}"* ]]; then
        second+=${entry:1:1}
    fi
    if ! [[ $third == *"${entry:2:1}"* ]]; then
        third+=${entry:2:1}
    fi
done

my_regex="'[$first][$second][$third]'"
echo "$my_regex"
