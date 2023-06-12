# sns-component

## To install the bindings via Composer, add the following to composer.json:
```{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/shivraj-ib/sns-component"
    }
  ],
  "require": {
    "https://github.com/shivraj-ib/sns-component": "dev-main"
  }
}
```

## Component use cases

```
use shivrajIb\snsComponent\SnsTopic;

$snsObject = new SnsTopic(
    $amazonRegion,
    $awsKey,
    $awsSecret,
);

// To create a new topic.
$response = $snsObject->createTopic($data);
var_dump($response);

// Add app subscriber to topic.
$response = $snsObject->addSubscriber($data);
var_dump($response);

// Publish to a topic.
$response = $snsObject->publishOverTopic($topic, $message);
var_dump($response);

// Confirm subscription.
$response = $snsObject->cofirmSubscription($data);
var_dump($response);
```