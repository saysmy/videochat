#/bin/bash

IP_LIST=$1
TODO=$2
CPTO=$3
while read line
do
	ADDR=`echo $line | awk {'print $1'}`
	USER=`echo $line | awk {'print $2'}`
	PASS=`echo $line | awk {'print $3'}`
	./send.exp ${ADDR} ${USER} ${PASS} ${TODO} ${CPTO} &
done < ${IP_LIST} 

wait
