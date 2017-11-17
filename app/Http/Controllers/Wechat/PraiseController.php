<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/17
 * Time: 下午4:37
 */

namespace App\Http\Wechat;


use App\Http\Controllers\Controller;
use App\Praise;
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
    public function save()
    {
        $user = request()->input('user');
        $ownerId = $user->{User::FIELD_ID};
        $objId = request()->input('obj_id');
        $objType = request()->input('obj_type');
        $collegeId = request()->input('college_id');

        $result = app(Praise::class)->createPraise($ownerId, $objId, $objType, $collegeId);

        return collect($result)->toArray();
    }

}