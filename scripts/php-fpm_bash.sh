#!/bin/bash

RUN_AS_USER=www-data

if [[ -n $1 ]];
then
    RUN_AS_USER=$1
fi

docker exec -e COLUMNS=$(tput cols) -e LINES=$(tput lines) -u ${RUN_AS_USER} -it ${PWD##*/}_$(basename ${BASH_SOURCE[0]} _bash.sh) bash
