<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/28
 * Time: 下午4:40
 */

namespace App\Http\Logic;


use GuzzleHttp\Client;

class EasemobLogic
{
    protected $orgName;
    protected $appName;
    protected $clientId;
    protected $clientSecret;
    protected $domain;
    protected $http;

    public function __construct()
    {
        $http = new Client;
        $this->http = $http;
        
        $this->orgName = env('EASEMOB_ORG_NAME');
        $this->appName = env('EASEMOB_APP_NAME');
        $this->clientId = env('EASEMOB_CLIENT_ID');
        $this->clientSecret = env('EASEMOB_CLIENT_SECRET');
        $this->domain = env('EASEMOB_DOMAIN');
    }

    public function getToken()
    {
        $url = $this->domain.'/'.$this->orgName.'/'.$this->appName.'/token';
        
        $data = [
            'grant_type'=>'client_credentials',
            'client_id'=>$this->clientId,
            'client_secret'=>$this->clientSecret
        ];
        
        $response = $this->http->post($url, ['form_params' => $data]);

        $token = json_decode((string) $response->getBody(), true);
        
        return $token;
        
    }

}