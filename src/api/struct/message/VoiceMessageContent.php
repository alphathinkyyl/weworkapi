<?php
/*
 * @Author: yuyanli 603447409@qq.com
 * @Date: 2022-10-19 11:12:12
 * @LastEditors: yuyanli 603447409@qq.com
 * @LastEditTime: 2023-02-01 14:44:08
 * @FilePath: \weworkapi\src\api\struct\message\VoiceMessageContent.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE 
 */
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

namespace alphathinkyyl\WeWorkApi\api\struct\message;


use alphathinkyyl\WeWorkApi\utils\error\ParameterError;
use alphathinkyyl\WeWorkApi\utils\Utils;

class VoiceMessageContent
{
    public $msgtype = "voice";
    public $media_id = null; // string

    /**
     * VoiceMessageContent constructor.
     *
     * @param null $media_id
     */
    public function __construct($media_id = null)
    {
        $this->media_id = $media_id;
    }

    /**
     * @throws ParameterError
     */
    public function CheckMessageSendArgs()
    {
        Utils::checkNotEmptyStr($this->media_id, "media_id");
    }

    /**
     * @param $arr
     */
    public function MessageContent2Array(&$arr)
    {
        Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentArr = array("media_id" => $this->media_id);
        Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
    }
}