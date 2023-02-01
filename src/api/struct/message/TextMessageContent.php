<?php
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

namespace alphathinkyyl\WeWorkApi\api\struct\message;


use alphathinkyyl\WeWorkApi\utils\error\QyApiError;
use alphathinkyyl\WeWorkApi\utils\Utils;

class TextMessageContent
{
    public $msgtype = "text";
    public $content = null; // string

    /**
     * TextMessageContent constructor.
     *
     * @param null $content
     */
    public function __construct($content = null)
    {
        $this->content = $content;
    }

    /**
     * @throws QyApiError
     */
    public function CheckMessageSendArgs()
    {
        $len = strlen($this->content);
        if ($len == 0 || $len > 2048) {
            throw new QyApiError("invalid content length " . $len);
        }
    }

    /**
     * @param $arr
     */
    public function MessageContent2Array(&$arr)
    {
        Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentArr = array("content" => $this->content);
        Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
    }
}