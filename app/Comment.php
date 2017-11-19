<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/11/13
 * Time: 下午2:58
 */

namespace App;


class Comment extends BaseModel
{
    protected $table = 'comments';

    /** field id */
    const FIELD_ID = 'id';

    /** field commenter_id 评论人 */
    const FIELD_ID_COMMENTER = 'commenter_id';

    /** field obj_id 被评论的对象Id */
    const FIELD_ID_OBJ = 'obj_id';

    /** field college_id 学校Id */
    const FIELD_ID_COLLEGE = 'college_id';

    /** field content 评论的内容 */
    const FIELD_CONTENT = 'content';

    /** field attachments 评论的附件 */
    const FIELD_ATTACHMENTS = 'attachments';

    /** field ref_comment_id 被评论的评论Id */
    const FIELD_ID_REF_COMMENT = 'ref_comment_id';

    /** field type 类型 */
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
        self::FIELD_ID_COMMENTER,
        self::FIELD_ID_COLLEGE,
        self::FIELD_ID_OBJ,
        self::FIELD_ID_REF_COMMENT,
        self::FIELD_CONTENT,
        self::FIELD_ATTACHMENTS,
        self::FIELD_TYPE,
        self::FIELD_STATUS,
        self::CREATED_AT,
        self::FIELD_UPDATED_AT
    ];

    /**
     * 评论人
     *
     * @author yezi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function commenter()
    {
        return $this->belongsTo(User::class,self::FIELD_ID_COMMENTER,User::FIELD_ID);
    }

    /**
     * 评论所属学校
     *
     * @author yezi
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function college()
    {
        return $this->belongsTo(Colleges::class,self::FIELD_ID_COLLEGE);
    }

    /**
     * 获取被评论的评论
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function refComment()
    {
        return $this->belongsTo(self::class,self::FIELD_ID_REF_COMMENT);
    }


}