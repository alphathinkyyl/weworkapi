<?php
/*
 * @Author: yuyanli 603447409@qq.com
 * @Date: 2022-10-19 11:12:12
 * @LastEditors: yuyanli 603447409@qq.com
 * @LastEditTime: 2022-12-29 14:06:13
 * @FilePath: \weworkapi\src\api\struct\message\NewsArticle.php
 * @Description: 这是默认设置,请设置`customMade`, 打开koroFileHeader查看配置 进行设置: https://github.com/OBKoro1/koro1FileHeader/wiki/%E9%85%8D%E7%BD%AE
 */
/**
 * Author:  Yejia
 * Email:   ye91@foxmail.com
 */

namespace alphathinkyyl\WeWorkApi\api\struct\message;


use alphathinkyyl\WeWorkApi\utils\error\ParameterError;
use alphathinkyyl\WeWorkApi\utils\Utils;

class NewsArticle
{
    public $title = null;       // string
    public $description = null; // string
    public $url = null;         // string 点击后跳转的链接。 最长2048字节，请确保包含了协议头(http/https)，小程序或者url必须填写一个
    public $picurl = null;      // string图文消息的图片链接，最长2048字节，支持JPG、PNG格式，较好的效果为大图 1068*455，小图150*150。
    // public $btntxt = null;      // string
    public $appid=null;//小程序appid，必须是与当前应用关联的小程序，appid和pagepath必须同时填写，填写后会忽略url字段
    public $pagepath=null;//点击消息卡片后的小程序页面，最长128字节，仅限本小程序内的页面。appid和pagepath必须同时填写，填写后会忽略url字段

    /**
     * NewsArticle constructor.
     *
     * @param null $title
     * @param null $description
     * @param null $url
     * @param null $picurl
     * @param null $appid
     * @param null $pagepath
     */
    public function __construct($title = null, $description = null, $url = null, $picurl = null, $appid = null,$pagepath=null)
    {
        $this->title = $title;
        $this->description = $description;
        $this->url = $url;
        $this->picurl = $picurl;
        // $this->btntxt = $btntxt;
        $this->appid=$appid;
        $this->pagepath=$pagepath;
    }

    /**
     * @throws ParameterError
     */
    public function CheckMessageSendArgs()
    {
        Utils::checkNotEmptyStr($this->title, "title");
        Utils::checkNotEmptyStr($this->url, "url");
    }

    /**
     * @return array
     */
    public function Article2Array()
    {
        $args = array();

        Utils::setIfNotNull($this->title, "title", $args);
        Utils::setIfNotNull($this->description, "description", $args);
        Utils::setIfNotNull($this->url, "url", $args);
        Utils::setIfNotNull($this->picurl, "picurl", $args);
        // Utils::setIfNotNull($this->btntxt, "btntxt", $args);

        return $args;
    }
}