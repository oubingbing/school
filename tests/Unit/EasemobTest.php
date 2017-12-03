<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/28
 * Time: 下午5:16
 */

namespace Tests\Unit;


use App\Http\Logic\EasemobLogic;
use Tests\TestCase;

class EasemobTest extends TestCase
{
    /**
     * @test
     */
    public function getToken()
    {
        $eas= new EasemobLogic();

        $token = $eas->getToken();

        dd(json_encode($token));
    }

}