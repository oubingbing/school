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
use Illuminate\Support\Facades\Request;

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
        $expectation = request()->input('Expectation');
        $introduce = request()->input('introduce');

        $validate = $this->validate($request, [
            'name' => 'required',
            'gender' => 'required',
            'major' => 'required',
            'Expectation' => 'required',
            'introduce' => 'required'
        ]);

        if($validate->errors()){
            throw new ApiException($validate->first());
        }

        $sale = new SaleFriendLogic();
        $result = $sale->save($user->id,$name,$gender,$major,$expectation,$introduce,$user->{User::FIELD_ID_COLLEGE});

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

        $query = SaleFriend::query()->orderBy(SaleFriend::FIELD_CREATED_AT,'desc');
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

        $saleFriend = SaleFriend::find($id);

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