<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/28
 * Time: 下午4:40
 */

namespace App\Http\Logic;

use App\Exceptions\ApiException;
use Illuminate\Support\Facades\Cache;

class EasemobAuthLogic
{
    protected $orgName;
    protected $appName;
    protected $clientId;
    protected $clientSecret;
    protected $domain;
    protected $http;

    public function __construct()
    {
        $http = new Http();
        $this->http = $http;
        
        $this->orgName = env('EASEMOB_ORG_NAME');
        $this->appName = env('EASEMOB_APP_NAME');
        $this->clientId = env('EASEMOB_CLIENT_ID');
        $this->clientSecret = env('EASEMOB_CLIENT_SECRET');
        $this->domain = env('EASEMOB_DOMAIN');
        $this->baseUrl = $this->domain.'/'.$this->orgName.'/'.$this->appName;
    }

    /**
     * 获取token
     *
     * @author yezi
     *
     * @return mixed
     */
    public function getToken()
    {
        if(Cache::get('easemoToken')){
            return Cache::get('easemoToken');
        }else{
            return $this->updateToken();
        }
    }

    /**
     * 更新token
     *
     * @author yezi
     *
     * @return mixed
     * @throws ApiException
     */
    public function updateToken()
    {
        $url = $this->baseUrl.'/token';

        $data = [
            'grant_type'=>'client_credentials',
            'client_id'=>$this->clientId,
            'client_secret'=>$this->clientSecret
        ];

        $response = $this->http->post($url, $data);

        if($response['status_code'] != 200){
            throw new ApiException('获取token失败');
        }

        $result = $response['result'];

        Cache::put('easemoToken',$result['access_token'],2);

        return $result['access_token'];
    }

    public function getUrl()
    {
        return $this->baseUrl;
    }


}