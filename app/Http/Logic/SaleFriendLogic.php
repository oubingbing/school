<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/28
 * Time: 上午11:47
 */

namespace App\Http\Logic;


use App\SaleFriend;

class SaleFriendLogic
{
    /**
     * 新增
     *
     * @author yezi
     *
     * @param $userId
     * @param $name
     * @param $gender
     * @param $major
     * @param $expectation
     * @param $introduce
     * @param null $collegeId
     * @return mixed
     */
    public function save($userId, $name, $gender, $major, $expectation, $introduce, $collegeId = null)
    {
        $result = SaleFriend::create([
            SaleFriend::FIELD_ID_OWNER => $userId,
            SaleFriend::FIELD_ID_COLLEGE => $collegeId,
            SaleFriend::FIELD_NAME => $name,
            SaleFriend::FIELD_GENDER => $gender,
            SaleFriend::FIELD_MAJOR => $major,
            SaleFriend::FIELD_EXPECTATION => $expectation,
            SaleFriend::FIELD_INTRODUCE => $introduce
        ]);

        return $result;
    }

    public function formatSingle($saleFriend,$user)
    {

    }



}