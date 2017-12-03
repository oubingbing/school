<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/28
 * Time: 下午3:48
 */

namespace App\Http\Logic;


use App\MatchLove;

class MatchLoveLogic
{
    /**
     * 新建
     *
     * @author yezi
     *
     * @param $userId
     * @param $username
     * @param $matchName
     * @param $content
     * @param $private
     * @param null $collegeId
     * @return mixed
     */
    public function createMatchLove($userId,$username,$matchName,$content,$private,$collegeId=null)
    {
        $result = MatchLove::create([
            MatchLove::FIELD_ID_OWNER=>$userId,
            MatchLove::FIELD_USER_NAME=>$username,
            MatchLove::FIELD_MATCH_NAME=>$matchName,
            MatchLove::FIELD_CONTENT=>$content,
            MatchLove::FIELD_PRIVATE=>$private,
            MatchLove::FIELD_ID_COLLEGE=>$collegeId
        ]);

        return $result;
    }

    /**
     * 格式化单挑
     *
     * @param $matchLove
     * @return mixed
     */
    public function formatSingle($matchLove)
    {
        return $matchLove;
    }

}