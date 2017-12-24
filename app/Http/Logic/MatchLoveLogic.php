<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/28
 * Time: 下午3:48
 */

namespace App\Http\Logic;


use App\Follow;
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
    public function createMatchLove($userId, $username, $matchName, $content, $private, $collegeId = null)
    {
        $result = MatchLove::create([
            MatchLove::FIELD_ID_OWNER => $userId,
            MatchLove::FIELD_USER_NAME => $username,
            MatchLove::FIELD_MATCH_NAME => $matchName,
            MatchLove::FIELD_CONTENT => $content,
            MatchLove::FIELD_PRIVATE => $private,
            MatchLove::FIELD_ID_COLLEGE => $collegeId,
            MatchLove::FIELD_IS_PASSWORD => MatchLove::ENUM_NOT_PASSWORD,
            MatchLove::FIELD_STATUS => 1
        ]);

        return $result;
    }

    /**
     * 格式化单挑
     *
     * @param $matchLove
     * @param $user
     * @return mixed
     */
    public function formatSingle($matchLove,$user)
    {
        //$matchLove->{MatchLove::FIELD_USER_NAME} = substr_replace($matchLove->{MatchLove::FIELD_USER_NAME},'*',1,2);

        $matchLove['follow'] = app(FollowLogic::class)->checkFollow($user->id,$matchLove['id'],Follow::ENUM_OBJ_TYPE_MATCH_LOVE)?true:false;

        return $matchLove;
    }

}