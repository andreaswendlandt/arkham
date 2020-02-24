<!DOCTYPE html> 
<html lang="en"> 
<head> 
<meta charset="utf-8"> 
<title>Cronguard</title> 
<meta name="viewport" content="width=device-width; initial-scale=1.0"> 
</head> 
<body> 
<?php
require_once('navigation.php');
?>
<div id="content">
<h1>Cronguard</h1> 
<h2>- Let your Cronjobs get evaluated -</h2>

<h3>#What it is</h3>
Cronguard is designed to evaluate cronjobs, one might say:"cron can do this this on his own" - yes and no.<br />
Yes cron can do that but it is error-prone, at least for piped commands, consider you execute the following:<br />
true | false | true && echo "success" || else echo "fail"<br />
Guess what will be echoed here, correct - success and with that the logic of the results for cronjobs is wrong.<br />
The reason is that every command of a piped command chain has its own return value which is stored in a shell array variable<br />
<i>${PIPESTATUS[*]}</i><br />
The second purpose of Cronguard is to get rid of these annoying mails you have to check as an admin every day:<br />
<i>'Yes the cronjob XY on Server Z was successful...'</i><br />
Instead of disabling the mailing from cron let Cronguard do the (dirty and lazy) work.<br />
Cronguard will only send mails in case of failed cronjobs and cronjobs that are running longer than one day.<br />
About successfully executed ones Cronguard does not care about.<br />
(technically for Cronguard every cronjob is an entry in a database and the successful ones will just be deleted)
<h3>#How it works</h3>
You let your cronjob execute by the cron_wrapper.sh script, just put the script in front of your cronjob the following way: <br /><br />
15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command" <br />
15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command | command | command" <br />
15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "script"<br /><br />
It will send some data via curl to the cronguard server(token, ident, host, start time, command and action) which writes them<br />
to a database, executes the cronjob and checks if the command(s)/script were successfully executed and makes then the second curl<br />
to the server with the result(failed or success).<br />
On the server runs a daemon that checks every minute for new database entries, entries with a 'success' as a result<br />
will just be deleted, entries with a 'fail' as a result will be send per mail - and then deleted, if there is no result<br />
and the cronjob is running longer than one day(86400 seconds) a mail will be send as well and the entry will be deleted.<br />
To get it working generate a token, store the token in /opt/cronguard/token.inc.sh<br />
(this is the location where the wrapper expects it), download the wrapper script cron_wrapper.sh and you can start.<br />
Beside generating a token you can - if you are not sure if your token is valid - validate your token and of course<br />
remove your token(and your email address)<br />
If you lost or forgot your token you can on the dedicated section let your token sent to you.<br />
This application has also a simple api, you can check if there are any entries(for your token), you can call this api like this:<br />
http://cronguard.ddns.net/cronguard_api.php?method=api&token=`your_token`<br />
Some further and additional information can be found here: 
<a href="https://github.com/andreaswendlandt/gotham/tree/master/cronguard">Cronguard on GitHub</a><br />
In case you want to manage cronguard on your own you can download everything you need for that(including .deb packages)<br />
from the GitHub link.<br /> 
Even some minimally invasive testing is possible as there is a docker image on DockerHub:<br />
<a href="https://hub.docker.com/r/andreaswendlandt/cronguard">Cronguard on Docker Hub</a><br />
<h3>#What do i need</h3>
Only 2 things, the script cron_wrapper.sh which executes your cronjobs and a valid token.<br />
You can get both on this site, the cron_wrapper.sh script from the download section,<br />
and the token you can generate at the generate token section(all you need for that is a valid email address)<br />
<h3>#What does it cost</h3>
NOTHING, using this service is absolutely and 100% for free! <br />
If you have a bad conscience about not paying for it - please support your local animal shelter. 
<h3>#About the author</h3>
My name is andreas, i'm a linux administrator/system engineer and open source enthusiast.<br />
I live in berlin and worked here for several companies - startups as well as public service and established company composite.<br />
More about me and what i do on the following links (and about cronguard on github and dockerhub).<br />
<a href="https://de.linkedin.com/in/andreas-wendlandt-231a3332">LinkedIn</a><br />
<a href="https://github.com/andreaswendlandt/">GitHub</a><br />
<a href="https://www.xing.com/profile/Andreas_Wendlandt3">Xing</a><br />
<a href="https://hub.docker.com/u/andreaswendlandt">Docker Hub</a><br />
<br />
In case of any questions, critics, praise or suggestions don't hesitate to contact me:<br />
<a href="mailto:andreas.cronguard@gmail.com">mail andreas</a>
