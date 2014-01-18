#!/bin/bash
for definition in {"1280x720","640x360"}; do 
  convert_mp4.sh $1 $definition > /dev/null &
  convert_webm.sh $1 $definition > /dev/null &
  convert_ogg.sh $1 $definition > /dev/null &
done