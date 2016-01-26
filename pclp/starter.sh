#!/bin/bash

cd compilerDaemonMk4b

if ps aux | grep "[b]ots.py" > /dev/null
then
    :
else
    python bots.py &
fi

if ps aux | grep "[m]ain.py" > /dev/null
then
    :
else
    python main.py &
fi

if ps aux | grep "[r]ejudge.py" > /dev/null
then
    :
else
    python rejudge.py &
fi
