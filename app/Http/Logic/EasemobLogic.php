<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/15
 * Time: 下午3:26
 */

namespace App\Http\Logic;


class EasemobLogic
{
    protected $token;
    protected $auth;
    protected $baseUrl;
    protected $http;
    protected $header;

    public function __construct(EasemobAuthLogic $easemobAuthLogic, Http $http)
    {
        $this->auth    = $easemobAuthLogic;
        $this->token   = $this->auth->getToken();
        $this->baseUrl = $this->auth->getUrl();
        $this->http    = $http;
        $this->header  = [
            'Authorization:Bearer ' . $this->token,
            'Content-Type:application/json'
        ];
    }

    /**
     * 注册单个用户
     *
     * @author yezi
     *
     * @param $username
     * @param $password
     * @return array
     */
    public function singleRegister($username, $password)
    {
        $url    = $this->baseUrl . '/users';
        $option = [
            'username' => $username,
            'password' => $password
        ];

        $result = $this->http->post($url, $option, $this->header);

        return $result;
    }

    /**
     * 注册多个用户
     *
     * @author yezi
     *
     * @param $users
     * @return array
     */
    public function batchSingleRegister($users)
    {
        $url    = $this->baseUrl . '/users';
        $option = $users;

        $result = $this->http->post($url, $option, $this->header);

        return $result;
    }

    /**
     * 获取单个用户
     *
     * @author yezi
     *
     * @param $username
     * @return array
     */
    public function user($username)
    {
        $url    = $this->baseUrl . '/users' . $username;
        $option = [];
        $result = $this->http->get($url, $option, $this->header);

        return $result;
    }

    /**
     * 获取多个用户信息
     *
     * @return array
     */
    public function users()
    {
        $url    = $this->baseUrl . '/users';
        $option = [];
        $result = $this->http->get($url, $option, $this->header);

        return $result;
    }

    public function send($from, $to = [], $type, $content)
    {
        $url = $this->baseUrl . '/messages';

        $option = [
            'target_type' => 'users',
            'target'      => $to,
            'msg'         => [
                'type'   => $type,
                'action' => $content
            ],
            'from'        => $from
        ];

        $result = $this->http->post($url, $option, $this->header);

        return $result;
    }

}