<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/13
 * Time: 下午2:58
 */

namespace App;


class Inbox extends BaseModel
{
    protected $table = 'inboxes';

    /** field id */
    const FIELD_ID = 'id';

    /** field owner_id 收信人Id */
    const FIELD_ID_OWNER = 'owner_id';

    /** field college_id 学校Id */
    const FIELD_ID_COLLEGE = 'college_id';

    /** field content 内容 */
    const FIELD_CONTENT = 'content';

    /** field obj_id 信箱涉及到的对象Id */
    const FIELD_ID_OBJ = 'obj_id';

    /** field obj_type 对象的类型 */
    const FIELD_OBJ_TYPE = 'obj_type';

    /** field action_type 信箱锁涉及到的操作类型 */
    const FIELD_ACTION_TYPE = 'action_type';

    /** field post_at 发送的时间 */
    const FIELD_POST_AT = 'post_at';

    /** field read_at 读信的时间 */
    const FIELD_READ_AT = 'read_at';

    /** field created_at */
    const FIELD_CREATED_AT = 'created_at';

    /** field updated_at */
    const FIELD_UPDATED_AT = 'updated_at';

    /** field deleted_at */
    const FIELD_DELETED_AT = 'deleted_at';

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_OWNER,
        self::FIELD_ID_COLLEGE,
        self::FIELD_ID_OBJ,
        self::FIELD_CONTENT,
        self::FIELD_OBJ_TYPE,
        self::FIELD_ACTION_TYPE,
        self::FIELD_POST_AT,
        self::FIELD_READ_AT,
        self::CREATED_AT,
        self::FIELD_UPDATED_AT
    ];


}