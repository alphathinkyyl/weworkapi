<?php
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

require_once __DIR__ . '/../vendor/autoload.php';

use alphathinkyyl\WeWorkApi\api\struct\ExternalContact\WelcomeMsg;
use alphathinkyyl\WeWorkApi\api\CorpAPI;
use alphathinkyyl\WeWorkApi\api\struct\ExternalContact\messages\TextMsg;
use alphathinkyyl\WeWorkApi\api\struct\Redis;

try {

    $redis = new Redis();
    $redis->host = '127.0.0.1';
    $redis->port = '6379';
    $redis->password = '';
    $redis->timeout = 0;

    $api = new CorpAPI('corpid', 'secret', $redis);

    $message = new WelcomeMsg();
    $message->welcome_code = "welcome_code";
    $message->text = new TextMsg();
    $message->text->content = "test message";

    $api->ExternalContactSendNewCustomerGreeting($message);

} catch (Exception $e) {
    echo $e;
}
