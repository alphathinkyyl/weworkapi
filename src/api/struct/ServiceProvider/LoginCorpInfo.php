<?php
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

namespace alphathinkyyl\WeWorkApi\api\struct\ServiceProvider;


use alphathinkyyl\WeWorkApi\utils\Utils;

class LoginCorpInfo
{
    public $corpid = null; // string

    /**
     * @param $arr
     *
     * @return LoginCorpInfo
     */
    static public function ParseFromArray($arr)
    {
        $info = new LoginCorpInfo();

        $info->corpid = Utils::arrayGet($arr, "corpid");

        return $info;
    }
}