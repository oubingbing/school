<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/17
 * Time: 下午4:37
 */

namespace App\Http\Logic;


use App\Post;
use App\Praise;
use App\SaleFriend;
use App\User;

class PraiseLogic
{
    /**
     * 点赞
     *
     * @author yezi
     *
     * @param $ownerId
     * @param $objId
     * @param $objType
     * @param null $collegeId
     * @return mixed
     */
    public function createPraise($ownerId, $objId, $objType, $collegeId = null)
    {
        $praise = Praise::create([
            Praise::FIELD_ID_OWNER => $ownerId,
            Praise::FIELD_ID_OBJ => $objId,
            Praise::FIELD_OBJ_TYPE => $objType,
            Praise::FIELD_ID_COLLEGE => $collegeId
        ]);

        return $praise;
    }

    /**
     * 添加点赞数
     *
     * @author yezi
     *
     * @param $type
     * @param $objId
     */
    public function incrementNumber($type,$objId)
    {
        switch ($type){
            case Praise::ENUM_OBJ_TYPE_POST:
                Post::query()->where(Post::FIELD_ID,$objId)->increment(Post::FIELD_PRAISE_NUMBER);
                break;
            case Praise::ENUM_OBJ_TYPE_SALE_FRIEND:
                SaleFriend::where(SaleFriend::FIELD_ID,$objId)->increment(SaleFriend::FIELD_PRAISE_NUMBER);
                break;
            default:
                Post::query()->where(Post::FIELD_ID,$objId)->increment(Post::FIELD_PRAISE_NUMBER);
                break;
        }
        
    }

    /**
     * 获取点赞
     *
     * @author yezi
     *
     * @param $objId
     * @param $objType
     * @return mixed
     */
    public function praise($objId,$objType)
    {
        $praise = Praise::where(Praise::FIELD_ID_OBJ,$objId)
            ->where(Praise::FIELD_OBJ_TYPE,$objType)
            ->get();

        return $praise;
    }

    public function formatBatchPraise($praises)
    {
        return collect($praises)->map(function ($item){

            return $this->formatSinglePraise($item);

        });
    }

    /**
     * 格式化点赞返回的格式
     *
     * @author yeiz
     *
     * @param $praise
     * @return array
     */
    public function formatSinglePraise($praise)
    {
        $praiseUser = User::find($praise['owner_id']);
        return [
            'id'=>$praise['id'],
            'owner_id'=>$praise[Praise::FIELD_ID_OWNER],
            'obj_type'=>$praise[Praise::FIELD_OBJ_TYPE],
            'college_id'=>$praise[Praise::FIELD_ID_COLLEGE],
            'user_id'=>$praiseUser->id,
            'nickname'=>$praiseUser->{User::FIELD_NICKNAME},
            'avatar'=>$praiseUser->{User::FIELD_AVATAR}
        ];
    }

}