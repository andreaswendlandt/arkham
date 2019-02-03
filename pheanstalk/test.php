<?php
include 'vendor/autoload.php';

use Pheanstalk\Pheanstalk;
// Create using autodetection of socket implementation
//$pheanstalk = Pheanstalk::create('127.0.0.1');
$pheanstalk = new Pheanstalk('127.0.0.1');



// ----------------------------------------
// producer (queues jobs)

$pheanstalk
  ->useTube('testtube')
  ->put("php hallo.php");
  //->put("job payload goes here\n");

// ----------------------------------------
// worker (performs jobs)

$job = $pheanstalk
  ->watch('testtube')
  ->ignore('default')
  ->reserve();

$cmd = $job->getData(); 
//$output = shell_exec("echo $job->getData()");
$output = shell_exec("$cmd");
//$output = shell_exec("php hallo.php");
echo $output;
//echo $job->getData();

$pheanstalk->delete($job);
