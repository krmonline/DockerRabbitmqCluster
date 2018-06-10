<?php
$queue  = '/queue/foo';
$msg    = 'bar';

/* connection */
try {
    $stomp = new Stomp('tcp://rb1:61613');
} catch(StompException $e) {
    die('Connection failed: ' . $e->getMessage());
}

/* send a message to the queue 'foo' */
$stomp->send($queue,"line1");
$stomp->send($queue,"line2");
$stomp->send($queue,"line3");

?>

