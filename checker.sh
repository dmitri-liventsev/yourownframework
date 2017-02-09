#!/bin/sh

 #

 SNOOZE=17

 COMMAND="./Job/standalonescript.php"

 while true

 do

  ${COMMAND}

  sleep ${SNOOZE}

 done