#!/bin/bash

mysql_root_pw=$1
new_mysql_user_password=$2

if [ $# -ne 2 ]; then
    echo "Error, this script needs two parameters, the root password and the new password for all users"
    echo "Usage: $0 <mysql_root_pw> <new_mysql_user_password>"
    exit 1
fi

for user in $(mysql -u root -p$mysql_root_pw  2>/dev/null -e "select User from mysql.user;"| egrep -v 'User|root|sys|mysql'); do 
    mysql -uroot -p$mysql_root_pw -e "update mysql.user set authentication_string=password('"$new_mysql_user_password"') Where User='"$user"';"
done
mysql -u root -p$mysql_root_pw 2>/dev/null -e "flush privileges;"
