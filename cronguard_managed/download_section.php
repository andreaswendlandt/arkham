<!DOCTYPE html> 
<html lang="de"> 
<head> 
<meta charset="utf-8"> 
<title>Download Section</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
echo "<div id=\"nav\"></div>";
?>
<div id="content">
<h1>Download Section</h1> 
Here you can download the two components you need to interact with the cronguard application<br />
(although the token.inc.sh is just an include file with a variable in)<br />
The file token.inc.sh <strong>MUST BE</strong> located under /opt/cronguard, the cron_wrapper.sh<br />
can be run from anywhere - you can put the token.inc.sh wherever you want as well but then<br />
you need to adjust the cron_wrapper.sh - the 37th line:<br />
...<br />
if ! source /opt/cronguard/token.inc.sh 2>/dev/null; then<br />
...<br />
Under the two download links you find the md5sum for each file.<br />
The only thing you need to do after downloading them and placing them to their desired location is to<br />
put the token you generated here <a href="http://cronguard.ddns.net/generate_token.php">Generate Token</a><br />
into the token.inc.sh file and you can run cronjobs like this:<br />
<br />
15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command" <br />
15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command | command | command" <br />
15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "script"<br /><br />
<h3>Download the Cronguard Wrapper</h3> 
<a href="download_wrapper.php">Download cron_wrapper.sh</a><br />
<h5>md5sum of cron_wrapper.sh</h5>
973d078761f290f3703f4f836236e437
<h3>Download the token file</h3> 
<a href="download_token.php">Download token.inc.sh</a><br />
<h5>md5sum of token.inc.sh</h5>
2711b362abf2b680c9efbb1b22936cf9
