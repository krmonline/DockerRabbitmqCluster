<?php
$queue  = '/queue/syslog';

try {
    $stomp = new Stomp('tcp://rb1:61613');
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$stomp->subscribe($queue);
while($stomp->hasFrame()){
  $frame = $stomp->readFrame();
  //var_dump($frame);
  //echo $frame->headers["MESSAGE"]."\n";
  $stomp->ack($frame);
}
unset($stomp);

?>
