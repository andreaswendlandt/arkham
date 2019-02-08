<?php
include 'vendor/autoload.php';

use Pheanstalk\Pheanstalk;

$job = "echo 'hallo mars' >/tmp/mars; sleep 2;php hallo_mars.php";

function put_job($job) {
    $pheanstalk = new Pheanstalk('127.0.0.1');
    $pheanstalk 
      ->useTube('testtube')
      ->put("$job");
}

put_job($job);
