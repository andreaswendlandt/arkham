#!/bin/bash
# nmap version 6.40

if [ $# -ne 2 ]; then 
  echo "Error, this script needs 2 parameters, a network and an ipaddress"
  echo "usage: $0 <10.1.7.0/24> <10.1.7.8>"
  exit 1
fi

network="$1"
ipaddress="$2"

result=$(nmap -v -sP $network | grep -A 1 "$ipaddress\>")
#result=$(nmap -sL $network | grep "$ipaddress\>")
echo $result

exit 0
  
  TCP_TIMEOUT=3
  while read host port; do
    (CURPID=$BASHPID;
    (sleep $TCP_TIMEOUT;kill $CURPID) &
    exec 3<> /dev/tcp/$host/$port
    ) 2>/dev/null
    case $? in
    0)
      echo $host $port is open;;
    1)
      echo $host $port is closed;;
    143) # killed by SIGTERM
       echo $host $port timeouted;;
     esac
  done
  ) 2>/dev/null
