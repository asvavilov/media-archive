media-archive
=============

scripts for organization media-archive

start thumbnails maker:
> ./thumbnails.sh "$from_dir" "$to_dir" > ./thumbnails.`date +"%Y%m%d%H%M%S"`.log 2>&1

where $from_dir is path to videos and $to_dir is path for thumbnails

start media-archive:
1) copy media.php and media.config-example.php to your web-server folder
2) edit media.config-example.php and save as media.config.php
3) open media.php in browser
