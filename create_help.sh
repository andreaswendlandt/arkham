#!/bin/bash
# author: andreaswendlandt
# last modified: 1.9.2017
# desc: some crazy-fancy-awesome stuff

mysql_root_pw=$(cat /root/.mysql_root_pw)
secret_user_pw=$(cat /root/.secret_user)
cur_date=$(date +%Y%m%d)

mysqldump -u root -p${mysql_root_pw} help_de > /opt/help_de/help.sql
mysqldump -u root -p${mysql_root_pw} help_en > /opt/help_en/help.sql

zip -r /path/to/somewhere/${cur_date}_de.zip /opt/help_de >/dev/null
zip -r /path/to/somewhere/help_${cur_date}_en.zip /opt/help_en >/dev/null

while true; do
    read -p "do you want to copy the new created help to the .*server? [yes/no]: " answer
    if [ "$answer" = "yes" ]; then
        sshpass -p "${secret_user_pw}" scp -l 9000 /path/to/somewhere/help_${cur_date}_* secret_user@server:/path/to/somewhere
        break
    elif
        [ "$answer" = "no" ]; then
        echo "nothing will be copied"
        break
    else
        echo "did not get a valid answer, please answer with either yes or no"
        continue
    fi
done
