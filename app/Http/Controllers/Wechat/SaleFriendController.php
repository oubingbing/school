<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/27
 * Time: 上午11:17
 */

namespace App\Http\Wechat;


use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use App\Http\Logic\PaginateLogic;
use App\Http\Logic\SaleFriendLogic;
use App\SaleFriend;
use App\User;
use Illuminate\Http\Request;

class SaleFriendController extends Controller
{
    /**
     * 新增
     *
     * @author yezi
     *
     * @param Request $request
     * @return mixed
     * @throws ApiException
     */
    public function save(Request $request)
    {
        $user = request()->input('user');
        $name = request()->input('name');
        $gender = request()->input('gender');
        $major = request()->input('major');
        $expectation = request()->input('expectation');
        $introduce = request()->input('introduce');
        $attachments = request()->input('attachments');

        $rule = [
            'name' => 'required',
            'gender' => 'required',
            'major' => 'required',
            'expectation' => 'required',
            'introduce' => 'required'
        ];

        $messages = [
            'name.required'=>'名字不能为空',
            'gender.required'=>'性别不能为空',
            'major.required'=>'专业不能为空',
            'Expectation.required'=>'期望不能为空',
            'introduce.required'=>'介绍不能为空',
        ];

        $validator = \Validator::make(request()->input(), $rule,$messages);
        if ($validator->fails()) {
            $messages = $validator->errors();
            throw new ApiException($messages->first(), 60001);
        }

        $sale = new SaleFriendLogic();
        $result = $sale->save($user->id,$name,$gender,$major,$expectation,$introduce,$attachments,$user->{User::FIELD_ID_COLLEGE});

        return $result;
    }

    /**
     * 获取
     *
     * @author yezi
     *
     * @return mixed
     */
    public function saleFriends()
    {
        $user = request()->input('user');
        $pageSize = request()->input('page_size',10);
        $pageNumber = request()->input('page_number',1);

        $pageParams = ['page_size'=>$pageSize, 'page_number'=>$pageNumber];

        $query = SaleFriend::query()->with(['poster','comments'])->orderBy(SaleFriend::FIELD_CREATED_AT,'desc');
        if($user->{User::FIELD_ID_COLLEGE}){
            $query->where(SaleFriend::FIELD_ID_COLLEGE,$user->{User::FIELD_ID_COLLEGE});
        }

        $saleFriends = app(PaginateLogic::class)->paginate($query,$pageParams, '*',function($saleFriend)use($user){
            return app(SaleFriendLogic::class)->formatSingle($saleFriend,$user);
        });

        return $saleFriends;
    }

    /**
     * 详情
     *
     * @author yezi
     *
     * @param $id
     * @return mixed
     */
    public function detail($id)
    {
        $user = request()->input('user');

        $saleFriend = SaleFriend::query()->with(['comments'])->find($id);

        if($saleFriend){
            return app(SaleFriendLogic::class)->formatSingle($saleFriend,$user);
        }else{
            return $saleFriend;
        }
    }

    /**
     * 删除
     *
     * @param $id
     * @return mixed
     */
    public function delete($id)
    {
        $user = request()->input('user');

        $result = SaleFriend::where(SaleFriend::FIELD_ID,$id)->where(SaleFriend::FIELD_ID_OWNER,$user->id)->delete();

        return $result;

    }

}