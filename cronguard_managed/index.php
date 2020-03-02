<!DOCTYPE html> 
<html lang="en"> 
  <head> 
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
  <div class="ui six item menu">
    <a class="active item" href="index.php">Home</a>
    <a class="item" href="generate_token.php">Generate Token</a>
    <a class="item" href="validate_token.php">Validate Token</a>
    <a class="item" href="download_section.php">Download Section</a>
    <a class="item" href="remove_token_mail.php">Remove Token</a>
    <a class="item" href="forgot_token.php">Forgot Token</a>
  </div>
  <div class="ui container">
    <div class="ui clearing segment">
    <h1 class="ui left floated header">Cronguard</h1> 
    <h3 class="ui right floated header">- Let your Cronjobs get evaluated -</h3>
    </div>
    <h4 class="ui top attached inverted header">What it is</h4>
    <div class="ui segment">
      Cronguard is designed to evaluate cronjobs, one might say:"cron can do this this on his own" - yes and no. Yes cron can do that but           it is error-prone, at least for piped commands, consider you execute the following:
      <p>true | false | true && echo "success" || else echo "fail"<br/ >
      Guess what will be echoed here, correct - success and with that the logic of the results for cronjobs is wrong. The reason is that            every command of a piped command chain has its own return value which is stored in a shell array variable<br />
      <i>${PIPESTATUS[*]}</i><br />
      The second purpose of Cronguard is to get rid of these annoying mails you have to check as an admin every day:<br />
      <i>'Yes the cronjob XY on Server Z was successful...'</i><br />
      Instead of disabling the mailing from cron let Cronguard do the (dirty and lazy) work. Cronguard will only send mails in case of failed       cronjobs and cronjobs that are running longer than one day. About successfully executed ones Cronguard does not care about.<br />
      (technically for Cronguard every cronjob is an entry in a database and the successful ones will just be deleted)
    </div>
    <h4 class="ui top attached inverted header">How it works</h4>
    <div class="ui segment">
      You let your cronjob execute by the cron_wrapper.sh script, just put the script in front of your cronjob the following way: <br /><br />
      15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command" <br />
      15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command | command | command" <br />
      15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "script"<br /><br />
      It will send some data via curl to the cronguard server(token, ident, host, start time, command and action) which writes them to a            database, executes the cronjob and checks if the command(s)/script were successfully executed and makes then the second curl to the           server with the result(failed or success). On the server runs a daemon that checks every minute for new database entries, entries with        a 'success' as a result will just be deleted, entries with a 'fail' as a result will be send per mail - and then deleted, if there is         no result and the cronjob is running longer than one day(86400 seconds) a mail will be send as well and the entry will be deleted. To         get it working generate a token, store the token in /opt/cronguard/token.inc.sh (this is the location where the wrapper expects it),          download the wrapper script cron_wrapper.sh and you can start. Beside generating a token you can - if you are not sure if your token is       valid - validate your token and of course remove your token(and your email address). If you lost or forgot your token you can on the          dedicated section let your token sent to you. This application has also a simple api, you can check if there are any                          entries(for your token), you can call this api like this:<br />
      https://cronguard.ddns.net/cronguard_api.php?method=api&token=`your_token`<br />
      Some further and additional information can be found here:<br /> 
      <a href="https://github.com/andreaswendlandt/gotham/tree/master/cronguard">Cronguard on GitHub</a><br />
      In case you want to manage cronguard on your own you can download everything you need for that(including .deb packages) from the              GitHub link.bEven some minimally invasive testing is possible as there is a docker image on DockerHub:<br />
      <a href="https://hub.docker.com/r/andreaswendlandt/cronguard">Cronguard on Docker Hub</a><br />
    </div>
    <h4 class="ui top attached inverted header">What do i need</h4>
    <div class="ui segment">
      Only 2 things, the script cron_wrapper.sh which executes your cronjobs and a valid token. You can get both on this site, the                  cron_wrapper.sh script from the download section, and the token you can generate at the generate token section(all you need for               that is a valid email address)
    </div>
    <h4 class="ui top attached inverted header">What does it cost</h4>
    <div class="ui segment">
      NOTHING, using this service is absolutely and 100% for free! If you have a bad conscience about not paying for it - please support your       local animal shelter. 
    </div>
    <h4 class="ui top attached inverted header">About the author</h4>
    <div class="ui segment">
      <img class="ui small right floated image" src="icke.jpeg">
      My name is andreas, i'm a linux administrator/system engineer and open source enthusiast. I live in berlin and worked here for several        companies<br />
      startups as well as public service and established company composite. More about me and what i do on the following links and about            cronguard on github and dockerhub).<br />
      <a href="https://de.linkedin.com/in/andreas-wendlandt-231a3332">LinkedIn</a><br />
      <a href="https://github.com/andreaswendlandt/">GitHub</a><br />
      <a href="https://www.xing.com/profile/Andreas_Wendlandt3">Xing</a><br />
      <a href="https://hub.docker.com/u/andreaswendlandt">Docker Hub</a><br />
      In case of any questions, critics, praise or suggestions don't hesitate to contact me:<br />
      <a href="mailto:andreas.cronguard@gmail.com">mail andreas</a>
    </div>
    <hr>
  </div>
  </body>
</html>
