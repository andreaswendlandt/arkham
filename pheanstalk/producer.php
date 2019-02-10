<?php

require 'vendor/autoload.php';

if (posix_getuid() != 0){
    exit("Error: this script must be run as root!\n");
}

function write_log($content){
    $log_file = "/var/log/job_producer.log";
    $log_time = date('M  j H:i:s');
    $log_handle = fopen($log_file, 'a') or die('Can not open:' .$log_file);
    $log_content = "$log_time  $content\n";
    fwrite($log_handle, $log_content);
    fclose($log_handle);
}

use Pheanstalk\Pheanstalk;

function put_job($job) {
    $pheanstalk = new Pheanstalk('192.168.1.45');
    $pheanstalk
      ->useTube('testtube')
      ->put("$job");
}

$jobs = array("echo 'hallo mars' >/tmp/mars; sleep 2;php hallo_mars.php",
	     "echo 'hallo welt' >/tmp/welt; sleep 2;php hallo_welt.php",
	     "echo 'hallo venus' >/tmp/venus; sleep 2;php hallo_venus.php"
            );

foreach ($jobs AS $job){
    put_job($job);
    write_log("$job put to the queue");
}
