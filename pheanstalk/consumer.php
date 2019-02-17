<?php
require 'vendor/autoload.php';

if (posix_getuid() != 0){
    exit("Error: this script must be run as root!\n");
}

function write_log($content){
    $log_file = "/var/log/job_consumer.log";
    $log_time = date('M  j H:i:s');
    $log_handle = fopen($log_file, 'a') or die('Can not open:' .$log_file);
    $log_content = "$log_time  $content\n";
    fwrite($log_handle, $log_content);
    fclose($log_handle);
}

use Pheanstalk\Pheanstalk;
$pheanstalk = new Pheanstalk('127.0.0.1');

$job = $pheanstalk
  ->watch('testtube')
  ->ignore('default')
  ->reserve();

$cmd = $job->getData(); 
exec($cmd, $output, $return);
if ($return != 0) {
    write_log("$cmd could not be processed");
    echo "$job could not be processed";
} else {
    write_log("$cmd succesfully processed");
    $user_output = implode($output);
    echo "$user_output\n";
}

$pheanstalk->delete($job);
