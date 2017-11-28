<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/27
 * Time: 上午10:44
 */

namespace App;


class SaleFriend extends BaseModel
{
    protected $table = 'sale_friends';

    /** field id */
    const FIELD_ID = 'id';

    /** field owner_id 所属人Id */
    const FIELD_ID_OWNER = 'owner_id';

    /** field college_id 学校Id */
    const FIELD_ID_COLLEGE = 'college_id';

    /** field name 舍友的名字 */
    const FIELD_NAME = 'name';

    /** field gender 性别 */
    const FIELD_GENDER = 'gender';

    /** field major 专业 */
    const FIELD_MAJOR = 'major';

    /** field Expectation 期望ta是什么样子的 */
    const FIELD_EXPECTATION = 'Expectation';

    /** field introduce 介绍下舍友 */
    const FIELD_INTRODUCE = 'introduce';

    /** field attachments 附件 */
    const FIELD_ATTACHMENTS = 'attachments';

    /** field comment_number 评论数 */
    const FIELD_COMMENT_NUMBER = 'comment_number';

    /** field praise_number 点赞数 */
    const FIELD_PRAISE_NUMBER = 'praise_number';

    /** field type */
    const FIELD_TYPE = 'type';

    /** field status */
    const FIELD_STATUS = 'status';

    /** field created_at */
    const FIELD_CREATED_AT = 'created_at';

    /** field updated_at */
    const FIELD_UPDATED_AT = 'updated_at';

    /** field deleted_at */
    const FIELD_DELETED_AT = 'deleted_at';

    /** 性别-男 */
    const ENUM_GENDER_BOY = 1;
    /** 性别-女 */
    const ENUM_GENDER_GIRL = 2;
    /** 性别-人妖 */
    const ENUM_GENDER_LADY_BOY = 3;
    /** 性别-未知生物 */
    const ENUM_GENDER_UNKNOWN = 4;

    protected $casts = [
        self::FIELD_ATTACHMENTS => 'array',
    ];

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_OWNER,
        self::FIELD_ID_COLLEGE,
        self::FIELD_NAME,
        self::FIELD_GENDER,
        self::FIELD_MAJOR,
        self::FIELD_EXPECTATION,
        self::FIELD_INTRODUCE,
        self::FIELD_ATTACHMENTS,
        self::FIELD_PRAISE_NUMBER,
        self::FIELD_COMMENT_NUMBER,
        self::FIELD_TYPE,
        self::FIELD_STATUS
    ];


}