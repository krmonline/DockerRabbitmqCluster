<?php
$queue  = '/queue/foo';

/* connection */
try {
    $stomp = new Stomp('tcp://rb1:61613');
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

$stomp->subscribe($queue);
$frame = $stomp->readFrame();
var_dump($frame);
unset($stomp);

?>
