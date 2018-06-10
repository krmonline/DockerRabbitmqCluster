<?php
$queue  = '/queue/syslog';

try {
    $stomp = new Stomp('tcp://rb1:61613');
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$stomp->subscribe($queue);
$timestamp = time();
$count = 0;
while(1){
  if(!$stomp->hasFrame()){
    //sleep(1);
    $timestamp_old = $timestamp;
    $timestamp = time();
    $diff = $timestamp - $timestamp_old;
    echo "$diff sec.\n";
    if($count){
      echo "event $count\n";
      $count = 0;
    }
    continue;
  }
  $frame = $stomp->readFrame();
  $count++;
  //echo $frame->headers["MESSAGE"]."\n";
  $stomp->ack($frame);
}
unset($stomp);

?>
