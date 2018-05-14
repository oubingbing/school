<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 14:41
 */

namespace App;


class GuardUser extends BaseModel
{
    const TABLE_NAME = 'guard_users';
    protected $table = self::TABLE_NAME;

    /** Field id */
    const FIELD_ID = 'id';

    /** Field nickname 用户昵称 */
    const FIELD_NICKNAME = 'nickname';

    /** Field mobile 用户手机号码 */
    const FIELD_MOBILE = 'mobile';

    /** Field avatar 用户头像 */
    const FIELD_AVATAR = 'avatar';

    /** field created_at */
    const FIELD_CREATED_AT = 'created_at';

    /** field updated_at */
    const FIELD_UPDATED_AT = 'updated_at';

    /** field deleted_at */
    const FIELD_DELETED_AT = 'deleted_at';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_NICKNAME,
        self::FIELD_MOBILE,
        self::FIELD_AVATAR,
        self::FIELD_CREATED_AT,
        self::FIELD_UPDATED_AT,
        self::FIELD_DELETED_AT
    ];
}