#!/bin/bash

if ps aux | grep "[b]ots.py" > /dev/null
then
    :
else
    python /root/pclp/compilerDaemonMk4b/bots.py &
fi

if ps aux | grep "[m]ain.py" > /dev/null
then
    :
else
    python /root/pclp/compilerDaemonMk4b/main.py &
fi

if ps aux | grep "[r]ejudge.py" > /dev/null
then
    :
else
    python /root/pclp/compilerDaemonMk4b/rejudge.py &
fi
