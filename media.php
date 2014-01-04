<?php
$config = file_exists("./media.config.php") ? include("./media.config.php") : null;
empty($config) and exit("configuration not found");

$videos_dir = __DIR__.$config["videos_path"];
$thumbnails_dir = __DIR__.$config["thumbnails_path"];

$out = `find -L '$videos_dir' -type f -regextype posix-egrep -regex '.*\.(mp4|avi|mpg|mpeg)' | sed 's|$videos_dir||' | sort -n`;
$videos = explode("\n", trim($out));
$thumbnails = array();
foreach ($videos as $video)
{
	if (file_exists($thumbnails_dir.$video))
	{
		$out = `find '$thumbnails_dir$video' -type f -name '*.png' | sed 's|$thumbnails_dir||' | sort -n`;
		$thumbnails[$video] = explode("\n", trim($out));
	}
}

?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>media</title>
<style>
.thumbnails-box {
	overflow-x: scroll;
	overflow-y: hidden;
}
</style>
</head>
<body>
<ul>
<? foreach ($videos as $video): ?>
	<li>
		<a href=".<?= $config["videos_path"] ?><?= $video ?>" target="_blank"><?= $video ?></a>
		<div class="thumbnails-box">
			<table>
				<tr>
					<? if (!empty($thumbnails[$video])): ?>
						<? foreach ($thumbnails[$video] as $thumbnail): ?>
							<td><img src=".<?= $config["thumbnails_path"] ?><?= $thumbnail ?>"</td>
						<? endforeach; ?>
					<? else: ?>
						<td>&nbsp;</td>
					<? endif; ?>
				</tr>
			</table>
		</div>
		<br>
	</li>
<? endforeach; ?>
</ul>
</body>
</html>
