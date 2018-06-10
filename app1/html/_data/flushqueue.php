<?php
$queue  = '/queue/foo';

try {
    $stomp = new Stomp('tcp://rb1:61613');
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$stomp->subscribe($queue);
$frame = $stomp->readFrame();
var_dump($frame);
$stomp->ack($frame);
unset($stomp);

?>
