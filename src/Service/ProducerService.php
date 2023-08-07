<?php

namespace Ecosystem\BusProducerBundle\Service;

use Aws\Sns\SnsClient;
use Psr\Log\LoggerInterface;
use Symfony\Contracts\Service\Attribute\Required;

class ProducerService
{
    #[Required]
    public LoggerInterface $logger;

    private SnsClient $client;
    private array $buses;

    public function __construct()
    {
        $config = [
            'region' => getenv('AWS_REGION'),
            'version' => '2010-03-31',
        ];

        if (getenv('LOCALSTACK')) {
            $config['credentials'] = false;
            $config['endpoint'] = 'http://localstack:4566';
        }

        $this->client = new SnsClient($config);
    }

    public function addBus(string $name, string $arn): void
    {
        $this->buses[$name] = $arn;
    }

    public function publish(array $payload, string $bus = 'default'): void
    {
        if (!isset($this->buses[$bus])) {
            $this->logger->error(sprintf('Bus "%s" not found.', $bus));
            return;
        }

        try {
            $this->client->publish([
                'TopicArn' => $this->buses[$bus],
                'Message' => json_encode($payload, JSON_PRESERVE_ZERO_FRACTION),
            ]);
            $this->logger->debug(sprintf('Dispatched message to bus "%s".', $bus));
        } catch (\Exception $exception) {
            $this->logger->critical(sprintf(
                'Unable to publish to bus "%s". Exception: "%s".',
                $bus,
                $exception->getMessage()
            ));
        }
    }
}
