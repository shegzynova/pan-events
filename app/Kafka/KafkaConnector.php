<?php

namespace App\Kafka;

use Illuminate\Queue\Connectors\ConnectorInterface;
use RdKafka\Conf;
use RdKafka\Consumer;
use RdKafka\Producer;

class KafkaConnector implements ConnectorInterface
{
    public function connect(array $config)
    {
        $con = new Conf();

        $con->set("bootstrap. servers", $config['bootstrap_servers']);
        $con->set("security protocol", $config['security_protocol']);
        $con->set("sasl.mechanisms", $config['sasl_mechanisms']);
        $con->set("sasl.username", $config['sasl_username']);
        $con->set("sasl.password", $config['sasl_password']);

        $producer = new Producer($con);

        $con->set("group.id", $config['group_id']);
        $con->set("auto.offset.reset", 'earliest');

        $consumer = new Consumer($con);

        return new KafkaQueue($consumer, $producer);
    }
}