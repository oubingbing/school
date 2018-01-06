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
    protected $followLogic;

    public function __construct(FollowLogic $followLogic)
    {
        $this->followLogic = $followLogic;
    }

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
     * 格式化单条
     *
     * @author yezi
     *
     * @param $matchLove
     * @param $user
     * @return mixed
     */
    public function formatSingle($matchLove,$user)
    {
        $strLen = mb_strlen($matchLove->{MatchLove::FIELD_USER_NAME},'utf8');

        $lastName = mb_substr( $matchLove->{MatchLove::FIELD_USER_NAME},-1,1,'utf-8');

        if($strLen > 1){
            $matchLove->{MatchLove::FIELD_USER_NAME} = str_pad($lastName,$strLen*2,"*",STR_PAD_LEFT);
        }else{
            $matchLove->{MatchLove::FIELD_USER_NAME} = '*';
        }

        $strLen = mb_strlen($matchLove->{MatchLove::FIELD_MATCH_NAME},'utf8');

        $lastName = mb_substr( $matchLove->{MatchLove::FIELD_MATCH_NAME},-1,1,'utf-8');

        if($strLen > 1){
            $matchLove->{MatchLove::FIELD_MATCH_NAME} = str_pad($lastName,$strLen*2,"*",STR_PAD_LEFT);
        }else{
            $matchLove->{MatchLove::FIELD_MATCH_NAME} = '*';
        }

        $matchLove['follow'] = $this->followLogic->checkFollow($user->id,$matchLove['id'],Follow::ENUM_OBJ_TYPE_MATCH_LOVE)?true:false;

        if($matchLove[MatchLove::FIELD_ID_OWNER] == $user->id){
            $matchLove['can_see'] = true;
        }else{
            $matchLove['can_see'] = false;
        }

        return $matchLove;
    }

    public function checkMatch($userName,$matchName)
    {
        $result = MatchLove::query()->where(MatchLove::FIELD_USER_NAME,$userName)->where(MatchLove::FIELD_MATCH_NAME,$matchName)->first();

        return $result;
    }

    /**
     * 匹配成功
     *
     * @author yeiz
     *
     * @param $userName
     * @param $matchName
     * @return int
     */
    public function matchSuccess($userName,$matchName)
    {
        $result = MatchLove::query()->where(function ($query)use($userName,$matchName){
            $query->where(MatchLove::FIELD_USER_NAME,$userName)->where(MatchLove::FIELD_MATCH_NAME,$matchName);
        })->orWhere(function ($query)use($userName,$matchName){
            $query->where(MatchLove::FIELD_USER_NAME,$matchName)->where(MatchLove::FIELD_MATCH_NAME,$userName);
        })->update([MatchLove::FIELD_STATUS=>MatchLove::ENUM_STATUS_SUCCESS]);

        return $result;
    }

    /**
     * 获取匹配结果
     *
     * @author yezi
     *
     * @param $userName
     * @param $matchName
     * @param $userId
     * @return \Illuminate\Database\Eloquent\Collection|static[]
     */
    public function matchResult($userName,$matchName,$userId)
    {
        $result = MatchLove::query()->with('user')->where(function ($query)use($userName,$matchName){
            $query->where(MatchLove::FIELD_USER_NAME,$userName)->where(MatchLove::FIELD_MATCH_NAME,$matchName);
        })->orWhere(function ($query)use($userName,$matchName){
            $query->where(MatchLove::FIELD_USER_NAME,$matchName)->where(MatchLove::FIELD_MATCH_NAME,$userName);
        })->get();

        $first = collect($result)->first();
        $last = collect($result)->last();

        $newResult = [];
        if ($first->{MatchLove::FIELD_ID_OWNER} == $userId){
            $newResult[0] = $first;
            $newResult[1] = $last;
        }else{
            $newResult[0] = $last;
            $newResult[1] = $first;
        }

        return $newResult;
    }

}