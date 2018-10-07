#!/bin/bash

if [ "$(id -u)" -ne "0" ]; then
    echo "Error: Cronguard must be run as root"
    exit 1
fi

daemon="cronguard"
pidfile="/var/run/cronguard.pid"
logfile="/var/log/cronguard.log"
pid="$$"
runInterval=60 

log() {
    echo $(date) "$@" >>$logfile
}

doCommands() {
  # This is where you put all the commands for the daemon.
  echo "Running commands."
}

################################################################################
# Below is the skeleton functionality of the daemon.
################################################################################

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

status_cronguard() {
    if [ $(check_cronguard; echo $?) -eq 1 ]; then
        echo "$daemon is running"
    else
        echo "$daemon is not running"
    fi
    exit 0
}

restart_cronguard() {
    if [ $(check_cronguard; echo $?) -eq 0 ]; then
        echo "$daemon is not running, starting it"
	log "Starting $daemon"
	start_cronguard
        return 2
    fi
    echo "Restarting $daemon"
    log "Restarting $daemon"
    stop_cronguard
    start_cronguard
}

check_cronguard() {
#	sleep 5
    if [ -z "$oldpid" ]; then
        return 0
    elif ps -ef | grep "$daemon" | grep -v grep > /dev/null 2>&1; then
        if ! [ -z "$oldpid" ]; then
            #if [ -f "$pidFile" ]; then
                if [ $(cat "$pidfile") -eq "$oldpid" ]; then
                    # Daemon is running.
                    return 1
	        else
                    log "$daemon is running with the wrong PID - restarting $daemon"
                    restart_cronguard
	            return 1 
	        fi
            #fi
	else
	    # Daemon is running
	    return 1
        fi
    else
        # Daemon isn't running.
        return 0
    fi
}

#loop() {
#  # This is the loop.
#  now=`date +%s`
#
#  if [ -z $last ]; then
#    last=`date +%s`
#  fi
#
#  # Do everything you need the daemon to do.
#  doCommands
#
#  # Check to see how long we actually need to sleep for. If we want this to run
#  # once a minute and it's taken more than a minute, then we should just run it
#  # anyway.
#  last=`date +%s`
#
#  # Set the sleep interval
#  if [[ ! $((now-last+runInterval+1)) -lt $((runInterval)) ]]; then
#    sleep $((now-last+runInterval))
#  fi
#
#  # Startover
#  loop
#}

loop() {
    while true; do
        echo "$(date) start" >/home/andreas/testfile
	sleep 5
	echo "$(date) stop" >>/home/andreas/testfile
    done
}


################################################################################
# Parse the command.
################################################################################

if [ -f "$pidfile" ]; then
    oldpid=$(cat "$pidfile")
fi
#checkDaemon
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
  echo "Error: Usage $0 {start | stop | restart | status}"
  exit 1
esac
