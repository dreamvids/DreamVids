ffmpeg -itsoffset -4 -i $1 -vcodec mjpeg -vframes 1 -an -f rawvideo -s 360x270 -y $1".jpg"
