#!/bin/bash

if [[ ! -z """${1}""" ]]
then
    export TARGET="${1}"
    export DEFAULT_INTERFACE=$(ip -o -4 route show to default | awk '/dev/ {print $5}')
    export DEFAULT_INTERFACE_ADDRESS=$(ifconfig ${DEFAULT_INTERFACE_ADDRESS}  | grep -o -h -U -P 'inet\s[^0-9]*([^\s]*)' | sed "s#inet\s[^0-9]*##gi")

    export MSFCONSOLE_START_SCRIPT=$(cat<<SCRIPT
set -g VERBOSE true
set -g HttpTrace true
set -g ANONYMOUS_LOGIN true
set -g RECORD_GUEST true
set -g THREADS 16

set -g RHOST ${TARGET}
set -g RHOSTS ${TARGET}

set -g LHOST ${DEFAULT_INTERFACE_ADDRESS}
SCRIPT
)


     export NMAP_BASE_SCAN=$(cat<<SCRIPT
\#\!/bin/bash

sudo nmap -v -sT -sV -O -A --open --reason -Pn -p- -T4 -vvv ${TARGET} -oA ${TARGET}_tcp_scan
SCRIPT
)

    echo """${MSFCONSOLE_START_SCRIPT}""" > """${HOME}/msfconsole.startup.rc"""
    echo """${NMAP_BASE_SCAN}""" > """${HOME}/nmap_tcp_scan.sh"""
    chmod +x """${HOME}/nmap_tcp_scan.sh"""
else
    echo "Usage: ${0} <TARGET>"
fi
