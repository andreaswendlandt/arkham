#!/bin/bash
    backup_folder=$1;
    user_folder=$2;
    if [ -z "$backup_folder" -o -z "$user_folder" ]; then
        echo "error, you need to provide 2 parameters"
        exit 1
    else
        for folder in $(ls -1 $backup_folder | grep -v roaming)
        do
            rsync -av ${backup_folder}/$folder ${user_folder}/$folder
        done
    fi
