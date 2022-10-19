<?php
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

namespace alphathinkyyl\WeWorkApi\api\struct\pay;


class QueryWorkWxRedpackReq
{
    public $nonce_str = null;  // string
    public $sign = null;       // string
    public $mch_billno = null; // string
    public $mch_id = null;     // string
    public $appid = null;      // string
}