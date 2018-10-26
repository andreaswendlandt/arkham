#!/bin/bash
source db.inc.sh
source mail.inc.sh

send_mail(){
    subject="$1"
    body="$2"
    echo "$body" | mail -s "$subject" $mail_to
}

cronguard(){
    query=$(mysql -u $db_user -p$db_password $db -e"SELECT token,result,host FROM $table" 2>&1 | grep -v 'Using a password' | tail -n +2)
    echo -e "$query" | while read line; do
        set $line
	if [ "$2" == "success" ]; then
            echo "$1 will be removed"
	    if mysql -u $db_user -p$db_password $db -e"DELETE FROM $table WHERE token = \"$1\"" 2>&1 | grep -v 'Using a password'; then
                #will be replaced with log
                echo "$1 from $3 removed"
            fi
        elif [ "$2" == "fail" ]; then
            echo "$1 will be sent"
            failed_command=$(mysql -u $db_user -p$db_password $db -e"SELECT command FROM $table WHERE token =\"$1\"" 2>&1 | grep -v 'Using a password' | tail -n +2)
            if send_mail "Failed Cronjob on $3" "This Cronjob failed: \"$failed_command\""; then
	        mysql -u $db_user -p$db_password $db -e"DELETE FROM $table WHERE token = \"$1\"" 2>&1 | grep -v 'Using a password'
	    fi    
        elif [ "$2" == "NULL" ]; then
            echo "$1 is still running"
	    current_time=$(date +%s)
            start_time=$(mysql -u $db_user -p$db_password $db -e"SELECT start_time FROM $table WHERE token =\"$1\"" 2>&1 | grep -v 'Using a password' | tail -n +2)
	    running_since=$((current_time-start_time))
            if [ $running_since -ge 8 ]; then
            #if [ $running_since -ge 86400 ]; then
            long_running_command=$(mysql -u $db_user -p$db_password $db -e"SELECT command FROM $table WHERE token =\"$1\"" 2>&1 | grep -v 'Using a password' | tail -n +2)
                if send_mail "Long running Cronjob on $3" "This Cronjob is running longer than one day($running_since seconds): \"$long_running_command\""; then
                    mysql -u $db_user -p$db_password $db -e"DELETE FROM $table WHERE token = \"$1\"" 2>&1 | grep -v 'Using a password'
	        fi
            fi
        fi
    done
}
cronguard
