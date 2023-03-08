<?php

namespace Ecosystem\BusBundle\Service;

use Aws\Sqs\SqsClient;
use Aws\Exception\AwsException;

class ConsumerService
{
    private SqsClient $client;
    private array $queues;

    public function __construct()
    {
        $this->client = new SqsClient([
            'region' => getenv('AWS_REGION'),
            'version' => '2012-11-05',
            'credentials' => false
        ]);
    }

    public function addQueue(string $name, string $url, $handler): void
    {
        $this->queues[$name] = [
            'url' => $url,
            'handler' => $handler,
        ];
    }

    public function receive(string $queue = 'default'): void
    {
        try {
            $result = $this->client->receiveMessage([
                'WaitTimeSeconds' => 20,
                'MaxNumberOfMessages' => 1,
                'MessageAttributeNames' => ['All'],
                'QueueUrl' => $this->queues[$queue]['url'],
            ]);

            if (isset($result['Messages'])) {
                $notification = json_decode($result['Messages'][0]['Body'], true);
                $message = json_decode($notification['Message'], true);
                $this->queues[$queue]['handler']($message);
                $this->client->deleteMessage([
                    'QueueUrl' => $this->queues[$queue]['url'],
                    'ReceiptHandle' => $result['Messages'][0]['ReceiptHandle'],
                ]);
            }
        } catch (AwsException $e) {
            error_log($e->getMessage());
        }
    }
}
