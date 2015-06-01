#/bin/bash

FILE_LIST=$1
IP_LIST=$2
while read line
do
    TODO=`echo $line | awk {'print $1'}`
    CPTO=`echo $line | awk {'print $2'}`
    while read line
    do
	    ADDR=`echo $line | awk {'print $1'}`
	    USER=`echo $line | awk {'print $2'}`
	    PASS=`echo $line | awk {'print $3'}`
	    ./send.exp ${ADDR} ${USER} ${PASS} ${TODO} ${CPTO} &
    done < ${IP_LIST} 
done < ${FILE_LIST}

wait
