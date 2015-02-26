ffmpeg -i $1 -acodec libfaac -ab 128k -vcodec libx264 -level 21 -refs 2 -b 345k -bt 345k -threads 1 -s 640x360 $1"_640x360p.mp4"
ffmpeg -i $1 -c:a libvorbis -b:a 128k -c:v libvpx -minrate 345k -maxrate 345k -b:v 345k -s 640x360 $1"_640x360p.webm"
php $2"scripts/cli.php" converter video $1 sd