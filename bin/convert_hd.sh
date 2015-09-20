ffmpeg -i $1 -acodec libfaac -ab 128k -vcodec libx264 -level 21 -refs 2 -b 3900k -bt 3900k -threads 1 -s 1920x1080 -cabac $1"_19200x1080p.mp4"
ffmpeg -i $1 -c:a libvorbis -b:a 128k -c:v libvpx -minrate 100k -maxrate 24M -b:v 3900k -s 1920x1080 $1"_19200x1080p.webm"
php $2"scripts/cli.php" converter video $1 hd
