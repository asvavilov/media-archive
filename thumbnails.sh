#!/bin/bash

### help:
## avconv:
# -r fps (every 1/x seconds)
# -ss start at time
# -an disable audio
# -y replace output
# -s WxH
# -vf videofilter

from_dir=$1
to_dir=$2

if [[ "$from_dir" == "" || "$to_dir" == "" ]]
then
    echo "need src and dest dirs"
    exit
fi

echo "Begin at `date +"%Y%m%d%H%M%S"`"

find -L "$from_dir" -type f -regextype posix-egrep -regex ".*\.(mp4|avi|mpeg|mpg)" |
while read video
do
    from_pathfile=$(echo "$video" | sed "s|$from_dir||g")
    from_path=$(dirname "$from_pathfile")
    from_file=$(basename "$from_pathfile")
    to_path="$from_path/$from_file"
    to_file="/%03d.png"
    echo "$to_path$to_file"
    if [ ! -d "$to_dir$to_path" ]
    then
	mkdir -p "$to_dir$to_path"
	echo "Processing..."
	avconv -i "$video" -vsync 1 -r 0.05 -ss 1 -vf "scale=300:-1" -an -y "$to_dir$to_path$to_file"
	# > /dev/null 2>&1
    else
	echo "Skip."
    fi
done

echo "End at `date +"%Y%m%d%H%M%S"`"
