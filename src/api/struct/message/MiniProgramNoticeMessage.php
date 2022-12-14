<?php


namespace alphathinkyyl\WeWorkApi\api\struct\message;


use alphathinkyyl\WeWorkApi\utils\error\ParameterError;
use alphathinkyyl\WeWorkApi\utils\Utils;
use Hamcrest\Util;
use alphathinkyyl\WeWorkApi\utils\error\QyApiError;

class MiniProgramNoticeMessage
{
    public $msgtype = "miniprogram_notice";  
    // 小程序appid，必须是与当前应用关联的小程序
    public $appid = null;
    //点击消息卡片后的小程序页面，最长1024个字节，仅限本小程序内的页面。该字段不填则消息点击后不跳转
    public $page = null;
    //消息标题，长度限制4-12个汉字（支持id转译）
    public $title = '';
    //消息描述，长度限制4-12个汉字（支持id转译）
    public $description = null;
    //是否放大第一个content_item
    public $emphasis_first_item = true;
    //消息内容键值对，最多允许10个item
    public $content_item = [];
    //表示是否开启id转译，0表示否，1表示是，默认0
    public $enable_id_trans = 0;
    //表示是否开启重复消息检查，0表示否，1表示是，默认0
    public $enable_duplicate_check = 0;
    //表示是否重复消息检查的时间间隔，默认1800s，最大不超过4小时
    public $duplicate_check_interval = 1800;


    /**
     * MiniProgramNoticeMessage constructor.
     *
     * @param null $appid
     */
    public function __construct($appid = null, $content_item=[])
    {
        $this->appid = $appid;
        $this->content_item=$content_item;

    }

    /**
     * @throws ParameterError
     */
    public function CheckMessageSendArgs()
    {
        Utils::checkNotEmptyStr($this->appid, "appid");
        Utils::checkNotEmptyStr($this->title, "title");
        Utils::checkNotEmptyStr($this->title, "title");
        $size = count($this->content_item);
        if ($size < 1 || $size > 10) throw new QyApiError("1~10 content_item should be given");

        foreach ($this->content_item as $item) {
            $item->CheckMessageSendArgs();
        }
    }

    /**
     * @param $arr
     */
    public function MessageContent2Array(&$arr)
    {
        Utils::setIfNotNull($this->msgtype, "msgtype", $arr);

        $contentList = array();
        foreach ($this->content_item as $item) {
            $contentList[] = $item->Content2Array();
        }

        $contentArr = array();
        {
            Utils::setIfNotNull($this->appid, "appid", $contentArr);
            Utils::setIfNotNull($this->page, "page", $contentArr);
            Utils::setIfNotNull($this->title, "title", $contentArr);
            Utils::setIfNotNull($this->description, "description", $contentArr);
            Utils::setIfNotNull($this->emphasis_first_item, "emphasis_first_item", $contentArr);
            Utils::setIfNotNull($contentList, "content_item", $contentArr);
            Utils::setIfNotNull($this->enable_id_trans, "enable_id_trans", $contentArr);
            Utils::setIfNotNull($this->enable_duplicate_check, "enable_duplicate_check", $contentArr);
            Utils::setIfNotNull($this->duplicate_check_interval, "duplicate_check_interval", $contentArr);
        }
        Utils::setIfNotNull($contentArr, $this->msgtype, $arr);
        // $arr[$this->msgtype]["content_item"] = $contentList;
    }
}
