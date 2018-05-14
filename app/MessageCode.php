<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/5/14 0014
 * Time: 14:49
 */

namespace App;


class MessageCode extends BaseModel
{
    const TABLE_NAME = 'message_codes';
    protected $table = self::TABLE_NAME;

    /** Field id */
    const FIELD_ID = 'id';

    /** Field mobile */
    const FIELD_MOBILE = 'mobile';

    /** Field code */
    const FIELD_CODE = 'code';

    /** field created_at */
    const FIELD_CREATED_AT = 'created_at';

    /** field updated_at */
    const FIELD_UPDATED_AT = 'updated_at';

    /** field deleted_at */
    const FIELD_DELETED_AT = 'deleted_at';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_CODE,
        self::FIELD_MOBILE,
        self::FIELD_CREATED_AT,
        self::FIELD_UPDATED_AT,
        self::FIELD_DELETED_AT
    ];

}