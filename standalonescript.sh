#!/bin/sh

 #

 SNOOZE=17

 COMMAND="./Job/checker.php"

 while true

 do

  ${COMMAND}

  sleep ${SNOOZE}

 done