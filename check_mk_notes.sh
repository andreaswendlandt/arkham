#!/bin/bash
# author: andreaswendlandt
# last mofified: 31.8.2017
# desc: some crazy-fancy-awesome stuff

# download and parse documentation file, put that to the custom notes section in check_mk
if scp server:/path_to_file /tmp/ >/dev/null; then
    cat /tmp/file | while read line; do
        name=$(echo $line | egrep -o 'servername_regex' | uniq)
        if  [ -n "$name" ]; then
            touch /path_to_check_mk/${name}
            txt=$(echo $line | egrep -o  '\<eco-vs-[[:digit:]]*]] .*\\' | sed -e 's/.*]] //' | sed -e 's/\\//')
            echo "$txt <a href=\"http://your_url/${ame}\">$name at your wiki</a>" >/path_to_check/${name}
        fi
    done
else
    echo "something went wrong, could not download the necessary file, please check manually!"
    exit 1
fi
