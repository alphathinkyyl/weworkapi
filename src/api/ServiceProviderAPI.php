<?php
/*
 * Copyright (C) 2017 All rights reserved.
 *   
 * @File ServiceProviderAPI.php
 * @Brief : 为服务商开放的接口, 使用服务商的token
 * @Author abelzhu, abelzhu@tencent.com
 * @Version 1.0
 * @Date 2017-12-26
 *
 */

namespace alphathinkyyl\WeWorkApi\api;


use alphathinkyyl\WeWorkApi\api\struct\ServiceProvider\GetLoginInfoRsp;
use alphathinkyyl\WeWorkApi\api\struct\ServiceProvider\GetRegisterCodeReq;
use alphathinkyyl\WeWorkApi\api\struct\ServiceProvider\GetRegisterInfoRsp;
use alphathinkyyl\WeWorkApi\api\struct\ServiceProvider\SetAgentScopeReq;
use alphathinkyyl\WeWorkApi\api\struct\ServiceProvider\SetAgentScopeRsp;
use alphathinkyyl\WeWorkApi\utils\error\HttpError;
use alphathinkyyl\WeWorkApi\utils\HttpUtils;
use alphathinkyyl\WeWorkApi\utils\error\InternalError;
use alphathinkyyl\WeWorkApi\utils\error\NetWorkError;
use alphathinkyyl\WeWorkApi\utils\error\ParameterError;
use alphathinkyyl\WeWorkApi\utils\error\QyApiError;
use alphathinkyyl\WeWorkApi\utils\Utils;

class ServiceProviderAPI extends API
{
    private $corpid = null;                // string
    private $provider_secret = null;       // string
    private $provider_access_token = null; // string

    /**
     * ServiceProviderAPI constructor.
     * 调用SetAgentScope/SetContactSyncSuccess 两个接口可以不用传corpid/provider_secret
     *
     * @param null $corpid
     * @param null $provider_secret
     */
    public function __construct($corpid = null, $provider_secret = null)
    {
        $this->corpid = $corpid;
        $this->provider_secret = $provider_secret;
    }

    /**
     * @return string|null
     * @throws HttpError
     * @throws InternalError
     * @throws NetWorkError
     * @throws ParameterError
     * @throws QyApiError
     */
    protected function GetProviderAccessToken()
    {
        if (!Utils::notEmptyStr($this->provider_access_token)) {
            $this->RefreshProviderAccessToken();
        }
        return $this->provider_access_token;
    }

    /**
     * @return string|void
     * @throws HttpError
     * @throws InternalError
     * @throws NetWorkError
     * @throws ParameterError
     * @throws QyApiError
     */
    protected function RefreshProviderAccessToken()
    {
        Utils::checkNotEmptyStr($this->corpid, "corpid");
        Utils::checkNotEmptyStr($this->provider_secret, "provider_secret");

        $args = array(
            "corpid"          => $this->corpid,
            "provider_secret" => $this->provider_secret,
        );
        $url = HttpUtils::MakeUrl("/cgi-bin/service/get_provider_token");
        $this->_HttpPostParseToJson($url, $args, false);
        $this->_CheckErrCode();

        $this->provider_access_token = $this->rspJson["provider_access_token"];
    }

    // ------------------------- 单点登录 -------------------------------------


    /**
     * @brief  GetLoginInfo : 获取登录用户信息
     *
     * @link   https://work.weixin.qq.com/api/doc#10991/获取登录用户信息
     *
     * @param $auth_code
     *
     * @return mixed
     * @throws HttpError
     * @throws InternalError
     * @throws NetWorkError
     * @throws ParameterError
     * @throws QyApiError
     */
    public function GetLoginInfo($auth_code)
    {
        Utils::checkNotEmptyStr($auth_code, "auth_code");
        $args = array("auth_code" => $auth_code);
        self::_HttpCall(self::GET_LOGIN_INFO, 'POST', $args);
        return GetLoginInfoRsp::ParseFromArray($this->rspJson);
    }

    // ------------------------- 注册定制化 -----------------------------------

    /**
     * @brief  GetRegisterCode : 获取注册码
     *
     * @link   https://work.weixin.qq.com/api/doc#11729/获取注册码
     *
     * @param GetRegisterCodeReq $GetRegisterCodeReq
     *
     * @return mixed
     * @throws HttpError
     * @throws InternalError
     * @throws NetWorkError
     * @throws ParameterError
     * @throws QyApiError
     */
    public function GetRegisterCode(GetRegisterCodeReq $GetRegisterCodeReq)
    {
        $args = $GetRegisterCodeReq->FormatArgs();
        self::_HttpCall(self::GET_REGISTER_CODE, 'POST', $args);
        return $this->rspJson["register_code"];
    }

    /**
     * @brief  GetRegisterInfo : 查询注册状态
     *
     * @link   https://work.weixin.qq.com/api/doc#11729/查询注册状态
     *
     * @param $register_code
     *
     * @return GetRegisterInfoRsp
     * @throws HttpError
     * @throws InternalError
     * @throws NetWorkError
     * @throws ParameterError
     * @throws QyApiError
     */
    public function GetRegisterInfo($register_code)
    {
        Utils::checkNotEmptyStr($register_code, "register_code");
        $args = array("register_code" => $register_code);
        self::_HttpCall(self::GET_REGISTER_INFO, 'POST', $args);
        return GetRegisterInfoRsp::ParseFromArray($this->rspJson);
    }


    /**
     * @brief  SetAgentScope : 设置授权应用可见范围
     *
     * @link   https://work.weixin.qq.com/api/doc#11729/设置授权应用可见范围
     *
     * @param string           $access_token 该接口只能使用注册完成回调事件或者查询注册状态返回的access_token
     * @param SetAgentScopeReq $SetAgentScopeReq
     *
     * @return SetAgentScopeRsp
     * @throws HttpError
     * @throws InternalError
     * @throws NetWorkError
     * @throws ParameterError
     * @throws QyApiError
     */
    public function SetAgentScope($access_token, SetAgentScopeReq $SetAgentScopeReq)
    {
        $args = $SetAgentScopeReq->FormatArgs();
        self::_HttpCall(self::SET_AGENT_SCOPE . "?access_token={$access_token}", 'POST', $args);
        return SetAgentScopeRsp::ParseFromArray($this->rspJson);
    }


    /**
     * @brief SetContactSyncSuccess : 设置通讯录同步完成
     *
     * @link  https://work.weixin.qq.com/api/doc#11729/设置通讯录同步完成
     *
     * @param string $access_token 该接口只能使用注册完成回调事件或者查询注册状态返回的access_token
     *
     * @throws HttpError
     * @throws InternalError
     * @throws NetWorkError
     * @throws ParameterError
     * @throws QyApiError
     */
    public function SetContactSyncSuccess($access_token)
    {
        self::_HttpCall(self::SET_CONTACT_SYNC_SUCCESS . "?access_token={$access_token}", 'GET', null);
    }
}
