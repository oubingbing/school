<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/17
 * Time: 下午4:37
 */

namespace App\Http\Logic;


use App\Praise;

class PraiseLogic
{
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

    public function praise($objId,$objType)
    {
        $praise = Praise::where(Praise::FIELD_ID_OBJ,$objId)
            ->where(Praise::FIELD_OBJ_TYPE,$objType)
            ->get();

        return $praise;
    }

}