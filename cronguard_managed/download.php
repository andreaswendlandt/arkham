<?php
$file_path = 'download/cron_wrapper.sh';
$filename = 'cron_wrapper.sh';
header("Content-Type: application/octet-stream");
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"".$filename."\"");
echo readfile($file_path);
