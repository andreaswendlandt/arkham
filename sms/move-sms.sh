#!/bin/bash
logfile="/var/log/iwatch/log"
temp=$(echo $2 | awk -F/ '{print $4}')
temp_file=/tmp/${temp}

log(){
  echo $(date) "$@" >>$logfile
}

for file in $(ls -1 "$1"); do
    i=$(ls -1 "$1" | head -n1)
    if [ -z "$i" ]; then
        continue
    fi
    if grep "$i" $temp_file >/dev/null 2>&1; then
        continue
    fi
    echo "$i" >>$temp_file
    server=$(echo ${pfad#*\\} | sed -e 's/\\/ /g' | awk '{print $1}')
            rsync -abz "${1}/${i}/" "${2}/${i}" && rm -r "${1}/${i}" || log "$i konnte nicht von $1 nach $2 verschoben werden"
            rsync -abz "${1}/${i}" "${2}/${i}" && rm -r "${1}/${i}" || log "$i konnte nicht von $1 nach $2 verschoben werden"
        log "$i in $1 von $user/$unix_user konnte nicht verschoben werden da der server nicht ermittelt werden konnte ($server)"
    sed -i "/$i/d" ${temp_file}
done
