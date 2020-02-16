<?php
$file_path = 'download/token.inc.sh';
$filename = 'token.inc.sh';
header("Content-Type: application/octet-stream");
header("Content-Transfer-Encoding: Binary");
header("Content-disposition: attachment; filename=\"".$filename."\"");
echo file_get_contents($file_path);
