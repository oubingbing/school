<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/17
 * Time: 下午4:37
 */

namespace App\Http\Wechat;


use App\Http\Controllers\Controller;
use App\Http\Logic\PraiseLogic;
use App\User;

class PraiseController extends Controller
{
    /**
     * 新增点赞
     *
     * @author yezi
     *
     * @return array
     */
    public function store()
    {
        $user = request()->input('user');
        $ownerId = $user->{User::FIELD_ID};
        $objId = request()->input('obj_id');
        $objType = request()->input('obj_type');
        $collegeId = $user->{User::FIELD_ID_COLLEGE};

        $result = app(PraiseLogic::class)->createPraise($ownerId, $objId, $objType, $collegeId);

        return app(PraiseLogic::class)->formatSinglePraise($result);
    }

}