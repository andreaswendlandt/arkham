<!DOCTYPE html> 
<html lang="de"> 
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
    <title>Download Section</title>
    <meta name="viewport" content="width=device-width; initial-scale=1.0">
  </head>
  <body>
    <div class="ui inverted segment">
      <div class="ui inverted secondary six item menu">
        <a class="item" href="index.php">Home</a>
        <a class="item" href="generate_token.php">Generate Token</a>
        <a class="item" href="validate_token.php">Validate Token</a>
        <a class="active item" href="download_section.php">Download Section</a>
        <a class="item" href="remove_token_mail.php">Remove Token</a>
        <a class="item" href="forgot_token.php">Forgot Token</a>
      </div>
    </div>
    <div class="ui container">
      <div class="ui clearing segment">
        <h2 class="ui left floated header">Download Section</h2>
      </div>
    <h4 class="ui top attached blue inverted header">What will be done here</h4>
    <div class="ui segment">
      Here you can download the two components you need for interacting with the cronguard application(although the token.inc.sh is just an include file with a variable in). The file token.inc.sh <strong>MUST BE</strong> located under /opt/cronguard/, the cron_wrapper.sh can be run from anywhere - you can put the token.inc.sh wherever you want as well but then you need to adjust the cron_wrapper.sh - the 37th line:<br />
      ...<br />
      if ! source /opt/cronguard/token.inc.sh 2>/dev/null; then<br />
      ...<br />
      Under the two download links you find the md5sum for each file. The only thing you need to do after downloading them and placing them to their desired location is to put the token you generated here <a href="https://cronguard.ddns.net/generate_token.php">Generate Token</a> into the token.inc.sh file and you can run cronjobs like this:<br />
      <br />
      15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command" <br />
      15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "command | command | command" <br />
      15  3  *  *  *  /opt/cronguard/cron_wrapper.sh "script"<br /><br />
    </div>
      <div class="ui horizontal segments">
        <div class="ui segment">
          <h3>Download the Cronguard Wrapper</h3>
          <a href="download_wrapper.php">
            <button class="ui labeled icon blue button">
              <i class="download icon"></i>
              Download cron_wrapper.sh
            </button>
          </a>
          <h5>md5sum of cron_wrapper.sh</h5>
          5d834a0d275ec812ca3950f4b1024b3e
        </div>
        <div class="ui segment">
          <h3>Download the token file</h3>
          <a href="download_token.php">
            <button class="ui labeled icon blue button">
              <i class="download icon"></i>
              Download token.inc.sh
            </button>
          </a>
          <h5>md5sum of token.inc.sh</h5>
          2711b362abf2b680c9efbb1b22936cf9
        </div>
      </div>
    </div>
  </body>
</html>
