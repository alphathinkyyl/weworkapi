<?php
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

namespace alphathinkyyl\WeWorkApi\api\struct\ServiceCorp;


use alphathinkyyl\WeWorkApi\utils\error\ParameterError;
use alphathinkyyl\WeWorkApi\utils\Utils;

class SetSessionInfoReq
{
    public $pre_auth_code = null; // string
    public $session_info = null;  // SessionInfo

    /**
     * @return array
     * @throws ParameterError
     */
    public function FormatArgs()
    {
        Utils::checkNotEmptyStr($this->pre_auth_code, "pre_auth_code");

        $args = array();

        $args["pre_auth_code"] = $this->pre_auth_code;
        $args["session_info"] = $this->session_info->FormatArgs();

        return $args;
    }
}