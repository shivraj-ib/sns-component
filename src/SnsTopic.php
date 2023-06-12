<?php 

namespace shivrajIb\snsComponent;

use Aws\Credentials\Credentials;
use Aws\Sns\SnsClient;
use Aws\Exception\AwsException;

class SnsTopic
{
    /**
     * AwsSnsService constructor.
     * @param String $amazonRegion
     * @param String $awsKey
     * @param String $awsSecret
     */
    public function __construct(
        private String $amazonRegion,
        private String $awsKey,
        private String $awsSecret,
    ) {
    }

    private function getClient()
    {
        return new SnsClient([
            'version' => '2010-03-31',
            'region' => $this->amazonRegion,
            'credentials' => new Credentials(
                $this->awsKey,
                $this->awsSecret,
            )
        ]);
    }

    /**
     * @param array $topicData
     * @return array
     */
    public function createTopic(array $topicData): array
    {
        try {
            $result = $this->getClient()->createTopic([
                'Name' => $topicData['topicName'],
            ]);
        } catch (AwsException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ];
        }
        
        return [
            'success' => true,
            'error' => '',
            'data' => $result
        ];
    }

    /**
     * @param array $filters
     * @return array
     */
    public function addSubscriber($filters): array
    {
        try {
            $result = $this->getClient()->subscribe([
                'Protocol' => $filters['protocol'] ?? 'https',
                'Endpoint' => $filters['endpoint'], //app specific listner end-point
                'ReturnSubscriptionArn' => true,
                'TopicArn' => $filters['topic'], //topic name eq. arn:aws:sns:us-east-1:1111:some-action
            ]);
        } catch (AwsException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ];
        }

        return [
            'success' => true,
            'error' => '',
            'data' => $result
        ];
    }

    /**
     * Publish to topic
     * @param String $topic
     * @param mixed $message
     * 
     * @return array
     */
    public function publishOverTopic(String $topic, $message): array
    {
        try {
            $result = $this->getClient()->publish([
                'Message' => $message,
                'TopicArn' => $topic,
            ]);
        } catch (AwsException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ];
        }

        return [
            'success' => true,
            'error' => '',
            'data' => $result
        ];
    }


    /**
     * Confirm subscription
     * @param array $filters
     * 
     * @return array
     */
    public function cofirmSubscription($filters): array
    {
        try {
            $result = $this->getClient()->confirmSubscription([
                'Token' => $filters['subscription_token'],
                'TopicArn' => $filters['topic'],
            ]);
        } catch (AwsException $e) {
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'data' => []
            ];
        }

        return [
            'success' => true,
            'error' => '',
            'data' => $result
        ];
    }
}