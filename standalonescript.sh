#!/bin/sh

 #

 SNOOZE=17

 COMMAND="php -q ./Job/checker.php"

 while true

 do

  ${COMMAND}

  sleep ${SNOOZE}

 done