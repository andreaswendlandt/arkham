#!/bin/bash

mysql_root_pw=$(cat /root/.mysql_root_pw)
#mysql_root_pw=$1

mysql -u root -p$mysql_root_pw 2>&1 -e "show variables where variable_name like 'character\_set\_%' or variable_name like 'collation%';" | egrep -v 'character_set_filesystem|character_set_system' | while read variable; do
    echo $variable |awk '$2 !~ /utf8mb4/ {print $1}' 
done
