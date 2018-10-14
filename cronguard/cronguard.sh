#!/bin/bash
# author: guerillatux
# desc: 
# last modified:

if [ "$(id -u)" -ne "0" ]; then
    echo "Error: Cronguard must be run as root"
    exit 1
fi

daemon="cronguard"
pidfile="/var/run/cronguard.pid"
logfile="/var/log/cronguard.log"
pid="$$"
interval=7

# Logging
log() {
    echo $(date) "$@" >>$logfile
}

# Starting Cronguard
start_cronguard() { 
    if [ $(check_cronguard; echo $?) -eq 1 ]; then
        echo "Error: $daemon is already running."
        exit 1
    fi
    echo "Starting $daemon with PID: $pid"
    echo "$pid" > "$pidfile"
    log "Starting $daemon"
    loop
}

# Stopping Cronguard
stop_cronguard() {
    if [ $(check_cronguard; echo $?) -eq 0 ]; then
        echo "Error: $daemon is not running"
        exit 1
    fi
    echo "Stopping $daemon"
    log "Stopping $daemon"
    if [ -s $pidfile ]; then
        kill -9 $(cat "$pidfile") >/dev/null 2>&1
    else
        echo "Error: Could not stop $daemon, please check manually!"
        log "Error: Could not stop $daemon, please check manually!"
    fi
}

# Status of Cronguard
status_cronguard() {
    if [ $(check_cronguard; echo $?) -eq 1 ]; then
        echo "$daemon is running"
    else
        echo "$daemon is not running"
    fi
    exit 0
}

# Restarting Cronguard
restart_cronguard() {
    if [ $(check_cronguard; echo $?) -eq 0 ]; then
        echo "$daemon is not running, starting it"
	log "Starting $daemon"
	start_cronguard
    fi
    echo "Restarting $daemon"
    log "Restarting $daemon"
    stop_cronguard
    start_cronguard
}

# Checking Cronguard
check_cronguard() {
    if ! [ -z "$oldpid" ] && ps -ef | grep "$daemon" | egrep -v "grep|$pid" > /dev/null 2>&1; then
        # Daemon is running
        return 1
    else
        # Daemon isn't running.
        return 0
    fi
}

# Cronguard Functionality
cronguard(){
        echo "$(date) start" >/home/andreas/testfile
	sleep 5
	echo "$(date) stop" >>/home/andreas/testfile
}

# Loop
loop(){
    now=`date +%s`
    cronguard
    last=`date +%s`
    result=$((now-last+interval))
    if [ $result -lt $interval -a $result -gt 0 ]; then
        sleep $((now-last+interval))
    fi
    loop
}

# Defining the oldpid variable for checkin purposes
if [ -f "$pidfile" ]; then
    oldpid=$(cat "$pidfile")
fi

# Daemon Functionality
case "$1" in
  start)
    start_cronguard
    ;;
  stop)
    stop_cronguard
    ;;
  status)
    status_cronguard
    ;;
  restart)
    restart_cronguard
    ;;
  *)
  echo "Error, Usage: $0 start | stop | restart | status"
  exit 1
esac
