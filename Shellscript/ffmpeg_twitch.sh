# !/usr/bin/env bash
# FFMPEG Start/Stop Script for Twitch
# by havoc

###################
#   Constants
###################

#### FOR FFMPEG

INPUT=" -i rtmp://localhost/live/"
OUTPUT=" -vcodec libx264 -vprofile baseline -g 10 -ar 44100 -ac 1 -f flv rtmp://live.twitch.tv/"
SCREENID="FFMPEG_"

#### USED PROGRAMMS

SCREEN=`which screen`
FFMPEG=`which ffmpeg`

#### COLORS

D='\E[0m'
R='\E[1;31m'
G='\E[1;32m'
Y='\E[1;33m'
B='\E[1;34m'

###################
#   Functions
###################

CHECK_COMMANDS () {

	if [ "$SCREEN" == "" ]; then
		echo "SCREEN NOT INSTALLED!"
		exit 1
	elif [ "$FFMPEG" == "" ]; then
		echo "FFMPEG NOT INSTALLED!"
		exit 1
	fi
}

FFMPEG_Start () {
	
	if [ "$1" == "" ] || [ "$2" == "" ]; then
		echo -e "USAGE: ./ffmpeg_twitch.sh start <streamer> <twitch_streamkey>"
		exit 1
	fi
	
	echo -e "${R}Starting ffmpeg... ${D}"
	
	NAME=$1
	STREAMKEY=$2
	
	SCREENID=$SCREENID$NAME
	FFMPEGCOMMAND=$FFMPEG$INPUT$NAME$OUTPUT$STREAMKEY
	
	RET=`$SCREEN -AmdS $SCREENID $FFMPEGCOMMAND`
	if [ "$RET" != "" ]; then
		echo -e "$RET"
	fi

}

FFMPEG_Stop () {
	if [ "$1" == "" ]; then
		echo -e "USAGE: ./ffmpeg_twitch.sh stop <streamer>"
		exit 1
	fi
	
	NAME=$1
	SCREENID=$SCREENID$NAME
	
	echo -e "${R}Stopping ffmpeg... ${D}"
	RET=`$SCREEN -X -S $SCREENID stuff "^C"`
	if [ "$RET" != "" ]; then
		echo -e "$RET"
	fi
}

###################
#   Main
###################

# DO NOT CHANGE ANYTHING BEYOND THIS LINE!!

echo "FFMPEG Twitch Script"

# check for root, parameters and installed commands
if [ $(id -u) = "0" ]; then
    	echo -e "${R}Don't start this as root!${D}"
   	exit 1
elif [ $# -eq 0 ]; then
	echo -e "${R}No Parameters! Use with <start|stop>!${D}"
	exit 1
fi

CHECK_COMMANDS

FIRSTPAR=$1

if [ "$FIRSTPAR" == "start" ]; then
	FFMPEG_Start $2 $3
elif [ "$FIRSTPAR" == "stop" ]; then
	FFMPEG_Stop $2
else
	echo "Wrong Parameter! Use with <start|stop>!"
	exit 1
fi

#### END