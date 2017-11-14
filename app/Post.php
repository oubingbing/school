<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/13
 * Time: 下午2:56
 */

namespace App;


class Post extends BaseModel
{
    protected $table = 'posts';

    /** field id 主键 */
    const FIELD_ID = 'id';

    /** field poster_id 发帖人Id */
    const FIELD_ID_POSTER = 'poster_id';

    /** field college_id 学校Id */
    const FIELD_ID_COLLEGE = 'college_id';

    /** field content 内容 */
    const FIELD_CONTENT = 'content';

    /** field attachments 贴子的附件,例如图片之类的 */
    const FIELD_ATTACHMENTS = 'attachments';

    /** field topic 贴子的主题 */
    const FIELD_TOPIC = 'topic';

    /** field type 贴子的类型 */
    const FIELD_TYPE = 'type';

    /** field status */
    const FIELD_STATUS = 'status';

    /** field created_at */
    const FIELD_CREATED_AT = 'created_at';

    /** field updated_at */
    const FIELD_UPDATED_AT = 'updated_at';

    /** field deleted_at */
    const FIELD_DELETED_AT = 'deleted_at';

    protected $casts = [
        self::FIELD_ATTACHMENTS => 'array',
    ];

    protected $fillable = [
        self::FIELD_ID,
        self::FIELD_ID_POSTER,
        self::FIELD_ID_COLLEGE,
        self::FIELD_CONTENT,
        self::FIELD_TOPIC,
        self::FIELD_ATTACHMENTS,
        self::FIELD_TYPE,
        self::FIELD_STATUS,
        self::CREATED_AT,
        self::FIELD_UPDATED_AT
    ];

    public function poster()
    {
        return $this->belongsTo(User::class,self::FIELD_ID_POSTER);
    }

    public function college()
    {
        return $this->belongsTo(Colleges::class,self::FIELD_ID_COLLEGE);
    }

}