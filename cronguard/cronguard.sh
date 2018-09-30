#!/bin/bash

if [ "$(id -u)" -ne "0" ]; then
    echo "Error: Cronguard must be run as root"
    exit 1
fi

daemon="cronguard"
pidfile="/var/run/cronguard.pid"
logfile="/var/log/cronguard.log"
pid="$$"
runInterval=60 # In seconds
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
    if [ $(check_cronguard) -eq 1 ]; then
        echo "Error: $daemon is already running."
        exit 1
    fi
    echo "Starting $daemon with PID: $pid"
    echo "$pid" > "$pidFile"
    log "Starting $daemon"
    loop
}

stop_cronguard() {
    if [ $(check_cronguard) -eq 0 ]; then
        echo "Error: $daemon is not running."
        exit 1
    fi
    echo "Stopping $daemon"
    log "Stopping $daemon"

    if [ -s $pidfile ]; then
        kill -9 $(cat "$pidfile") >/dev/null 2>&1
    fi
}

status_cronguard() {
    if [ $(check_cronguard -eq 1 ]; then
        echo "$daemon is running"
    else
      echo "$daemon is not running"
    fi
    exit 0
}

restart_crongurad() {
    if [ $(check_crongurad) -eq 0 ]; then
        echo "$daemonName is not running"
        exit 1
    fi
    stop_cronguard
    start_cronguard
}

checkDaemon() {
  # Check to see if the daemon is running.
  # This is a different function than statusDaemon
  # so that we can use it other functions.
  if [ -z "$oldPid" ]; then
    return 0
  elif [[ `ps aux | grep "$oldPid" | grep -v grep` > /dev/null ]]; then
    if [ -f "$pidFile" ]; then
      if [[ `cat "$pidFile"` = "$oldPid" ]]; then
        # Daemon is running.
        # echo 1
        return 1
      else
        # Daemon isn't running.
        return 0
      fi
    fi
  elif [[ `ps aux | grep "$daemonName" | grep -v grep | grep -v "$myPid" | grep -v "0:00.00"` > /dev/null ]]; then
    # Daemon is running but without the correct PID. Restart it.
    log '*** '`date +"%Y-%m-%d"`": $daemonName running with invalid PID; restarting."
    restartDaemon
    return 1
  else
    # Daemon not running.
    return 0
  fi
  return 1
}

loop() {
  # This is the loop.
  now=`date +%s`

  if [ -z $last ]; then
    last=`date +%s`
  fi

  # Do everything you need the daemon to do.
  doCommands

  # Check to see how long we actually need to sleep for. If we want this to run
  # once a minute and it's taken more than a minute, then we should just run it
  # anyway.
  last=`date +%s`

  # Set the sleep interval
  if [[ ! $((now-last+runInterval+1)) -lt $((runInterval)) ]]; then
    sleep $((now-last+runInterval))
  fi

  # Startover
  loop
}


################################################################################
# Parse the command.
################################################################################

if [ -f "$pidFile" ]; then
  oldPid=`cat "$pidFile"`
fi
checkDaemon
case "$1" in
  start)
    startDaemon
    ;;
  stop)
    stopDaemon
    ;;
  status)
    statusDaemon
    ;;
  restart)
    restartDaemon
    ;;
  *)
  echo "\033[31;5;148mError\033[39m: usage $0 { start | stop | restart | status }"
  exit 1
esac

exit 0
