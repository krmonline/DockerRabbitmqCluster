<?php

$conf = new RdKafka\Conf();

// Set the group id. This is required when storing offsets on the broker
$conf->set('group.id', 'myConsumerGroup');

$rk = new RdKafka\Consumer($conf);
$rk->addBrokers("kafka");

$topicConf = new RdKafka\TopicConf();
$topicConf->set('auto.commit.interval.ms', 100);

// Set the offset store method to 'file'
$topicConf->set('offset.store.method', 'file');
$topicConf->set('offset.store.path', sys_get_temp_dir());

// Alternatively, set the offset store method to 'broker'
// $topicConf->set('offset.store.method', 'broker');

// Set where to start consuming messages when there is no initial offset in
// offset store or the desired offset is out of range.
// 'smallest': start from the beginning
$topicConf->set('auto.offset.reset', 'smallest');

$topic = $rk->newTopic("syslog", $topicConf);

// Start consuming partition 0
$topic->consumeStart(0, RD_KAFKA_OFFSET_STORED);
$timestamp = time();                                                
$count = 0; 
while (true) {
    $message = $topic->consume(0, 120*10000);
    switch ($message->err) {
        case RD_KAFKA_RESP_ERR_NO_ERROR:
            //var_dump($message);
            if(!$count){                    
              $timestamp = time();          
            }                                      
            $count++; 
            break;
        case RD_KAFKA_RESP_ERR__PARTITION_EOF:
            echo "No more messages; will wait for more\n";
            $timestampOld = $timestamp;                                                        
            $timestamp = time();                                           
            $diff = $timestamp - $timestampOld;                                                
            echo $diff." sec.\n";                             
            echo $count." msg.\n";                                         
            $count = 0; 
            break;
        case RD_KAFKA_RESP_ERR__TIMED_OUT:
            echo "Timed out\n";
            break;
        default:
            throw new \Exception($message->errstr(), $message->err);
            break;
    }
}

?>

