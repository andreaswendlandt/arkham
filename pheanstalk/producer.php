<?php

require 'vendor/autoload.php';

if (posix_getuid() != 0){
    exit("Error: this script must be run as root!");
}

function write_log($content){
    $log_file = "/var/log/job_producer.log";
    $log_time = date('M  j H:i:s');
    $log_handle = fopen($log_file, 'a') or die('Can not open:' .$log_file);
    $content = str_replace(array("\n", "\r"), '', $content);
    $log_content = "$log_time  $content\n";
    fwrite($log_handle, $log_content);
    fclose($log_handle);
}

$jobfile = "/var/www/html/php/jobs.txt";
if (file_exists($jobfile)){
    if(0 == filesize($jobfile)){
	write_log("jobfile $jobfile exists but is empty - aborting!");
	exit("ERROR - empty jobfile $jobfile!");
    }else{
        write_log("jobfile $jobfile exists and is not empty - proceeding");
    }
}else{
    write_log("jobfile $jobfile does not exist - aborting!");
    exit("ERROR - jobfile $jobfile does not exist");
}

use Pheanstalk\Pheanstalk;

function put_job($job) {
    $pheanstalk = new Pheanstalk('192.168.1.45');
    $pheanstalk
      ->useTube('testtube')
      ->put("$job");
}

$jobs = array();

if ($job_file = @fopen("$jobfile", "r")){
    write_log("jobfile $jobfile opened for reading");
}else{
    write_log("Could not open jobfile $jobfile for reading");
    exit("ERROR: Could not open jobfile $jobfile, it seems the file is not readable!");
}

while (($line = fgets($job_file)) !== false)
    array_push($jobs, $line);

fclose($job_file);

foreach ($jobs AS $job){
    put_job($job);
    write_log("job \"$job\" put to the queue");
}
