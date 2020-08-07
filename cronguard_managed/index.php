<!DOCTYPE html> 
<html lang="en"> 
  <head> 
    <link rel="apple-touch-icon" sizes="57x57" href="fav/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="fav/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="fav/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="fav/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="fav/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="fav/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="fav/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="fav/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="fav/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="fav/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="fav/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="fav/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="fav/favicon-16x16.png">
    <link rel="manifest" href="fav/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="fav/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta charset="utf-8"> 
    <link rel="stylesheet" type="text/css" href="semantic/dist/semantic.min.css">
    <script
      src="https://code.jquery.com/jquery-3.1.1.min.js"
      integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8="
      crossorigin="anonymous"></script>
    <script src="semantic/dist/semantic.min.js"></script>
    <title>Cronguard</title> 
    <meta name="viewport" content="width=device-width; initial-scale=1.0"> 
  </head> 
  <body> 
    <div class="ui inverted segment">
      <div class="ui inverted secondary six item menu">
        <a class="active item" href="index.php">Home</a>
        <a class="item" href="generate_token.php">Generate Token</a>
        <a class="item" href="validate_token.php">Validate Token</a>
        <a class="item" href="download_section.php">Download Section</a>
        <a class="item" href="remove_token_mail.php">Remove Token</a>
        <a class="item" href="forgot_token.php">Forgot Token</a>
      </div>
    </div>
    <div class="ui container">
      <div class="ui clearing segment">
        <h1 class="ui left floated header">Cronguard</h1> 
        <h2 class="ui right floated header">- Let your Cronjobs get evaluated -</h2>
      </div>
      <h4 class="ui top blue attached inverted header">What it is</h4>
      <div class="ui segment">
        Cronguard was developed to evaluate cronjobs, you could say: "cron can do this alone" - yes and no. Yes cron can do that but it is prone to errors, at least for piped commands, imagine you execute the following: <i>true | false | true && echo "success" || else echo "fail"</i><br/ >
        Guess what is the output here - success and with that the logic of the results for cronjobs is wrong. The reason is that every command of a piped command chain has its own return value which is stored in a shell array variable - <i>${PIPESTATUS[*]}</i> - and the bash(and thus cron) uses always the last one as the "result".<br />
        The second purpose of Cronguard is to get rid of these annoying mails you have to check as an admin every day: <i>'Yes the cronjob XY on Server Z was successful...'</i><br />
        Instead of disabling the mailing functionality from cron let Cronguard do the (dirty and lazy) work. Cronguard will only send mails in case of failed cronjobs and cronjobs that run longer than one day. About successfully executed ones Cronguard does not care.
      </div>
      <h4 class="ui top blue attached inverted header">How it works</h4>
      <div class="ui segment">
        You let the cron_wrapper.sh script execute your cronjobs, just put the script in front of your cronjob the following way: <br /><br />
        15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command" <br />
        15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command | command | command" <br />
        15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "script"<br /><br />
        It will send the following data(token, ident, host, start time, command and action) via curl to the cronguard server which writes them to a database, executes the cronjob and checks if the command(s)/script were executed successfully and makes then a second curl to the server with the result(fail or success). On the server runs a daemon which checks once per minute if there are new database entries, entries with a 'success' as a result are just deleted, entries with a 'fail' as a result are sent by mail - and then deleted, if there is no result(NULL) and the cronjob runs longer than one day(86400 seconds) a mail is also sent and the entry is deleted. In order to get it to work generate a token, store the token in /opt/cronguard/token.inc.sh (this is the location where the wrapper expects it), download the wrapper script cron_wrapper.sh and you can start. Besides the generating of token you can - if you are not sure if your token is valid - validate your token and of course delete your token(and your email address). If you have forgotten or lost your token you can have your token sent to you on the corresponding page. This application also has a simple api, you can check if there are entries(for your token), you can call this api as follows:<br />
        https://cronguard.ddns.net/cronguard_api.php?method=api&token=`your_token`<br />
        Some further and additional information can be found here: <a href="https://github.com/andreaswendlandt/gotham/tree/master/cronguard">Cronguard on GitHub</a><br />
        If you want to host cronguard yourself you can download everything you need from the GitHub link (including .deb packages). Even a minimal invasive testing is possible as there is a docker image on DockerHub: <a href="https://hub.docker.com/r/andreaswendlandt/cronguard">Cronguard on Docker Hub</a><br />
      </div>
      <h4 class="ui top blue attached inverted header">What do i need</h4>
      <div class="ui segment">
        Only 2 things, the script cron_wrapper.sh which executes your cronjobs and a valid token. You can get both here, the cron_wrapper.sh script from the download page <a href="https://cronguard.ddns.net/download_section.php">Download Section</a>, and the token you can generate at the generate token page <a href="https://cronguard.ddns.net/generate_token.php">Generate Token</a> (all you need for that is a valid email address)
      </div>
      <h4 class="ui top blue attached inverted header">What does it cost</h4>
      <div class="ui segment">
        NOTHING, using this service is absolutely and 100% for free! If you have a bad conscience about not paying for it - please support your local animal shelter. 
      </div>
      <h4 class="ui top blue attached inverted header">About the author</h4>
      <div class="ui segment">
        <img class="ui small right floated image" src="icke.jpeg">
        My name is andreas, i'm a linux administrator/system engineer and open source enthusiast. I live in berlin and worked here for various companies.<br />
        Startups as well as public service and established companies. More about me and what i do on the following social media buttons and about cronguard on github and dockerhub.<br />
        <a href="https://de.linkedin.com/in/andreas-wendlandt-231a3332">
          <button class="ui icon button">
            <i class="linkedin icon"></i>
            LinkedIn
          </button>
        </a>
        <a href="https://www.xing.com/profile/Andreas_Wendlandt3">
          <button class="ui icon button">
            <i class="xing icon"></i>
            Xing
          </button>
        </a>
        <a href="https://github.com/andreaswendlandt/">
          <button class="ui icon button">
            <i class="github icon"></i>
            GitHub
          </button>
        </a>
        <a href="https://hub.docker.com/u/andreaswendlandt">
          <button class="ui icon button">
            <i class="docker icon"></i>
            DockerHub
          </button>
        </a>
        <br /><br />
        In case of any questions, critics, praise or suggestions don't hesitate to contact me.<br />
        <a href="mailto:andreas.cronguard@gmail.com">
          <button class="ui labeled icon blue button">
            <i class="envelope icon"></i>
            mail andreas
          </button>
        </a>
      </div>
    </div>
  </body>
</html>
