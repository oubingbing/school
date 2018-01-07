<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/15
 * Time: 下午12:02
 */

namespace App\Http\Logic;


use App\Comment;
use App\Exceptions\ApiException;
use App\Inbox;
use App\MatchLove;
use App\Post;
use App\Praise;
use App\SaleFriend;
use App\User;
use Carbon\Carbon;

class InboxLogic
{
    protected $paginateLogic;

    public function __construct(PaginateLogic $paginateLogic)
    {
        $this->paginateLogic = $paginateLogic;
    }

    /**
     * 往消息盒子投递信息
     *
     * @author yezi
     *
     * @param $fromId
     * @param $toId
     * @param $objId
     * @param $content
     * @param $objType
     * @param $actionType
     * @param $postAt
     * @return mixed
     * @throws ApiException
     */
    public function send($fromId, $toId, $objId, $content, $objType, $actionType, $postAt)
    {
        $fromUser = User::query()->find($fromId);
        $toUser = User::query()->find($toId);

        if (!$fromUser)
            throw new ApiException('用户不存在', 404);

        if (!$toUser)
            throw new ApiException('用户不在', 404);

        $checkResult = $this->checkObj($objId, $objType);
        if (!$checkResult)
            throw new ApiException('对象不存在', 404);

        $result = Inbox::create([
            Inbox::FIELD_ID_FROM => $fromId,
            Inbox::FIELD_ID_TO => $toId,
            Inbox::FIELD_ID_OBJ => $objId,
            Inbox::FIELD_CONTENT => $content,
            Inbox::FIELD_OBJ_TYPE => $objType,
            Inbox::FIELD_ACTION_TYPE => $actionType,
            Inbox::FIELD_POST_AT => $postAt
        ]);

        //todo 发送环信消息

        return $result;
    }

    /**
     * 检测信息对象是否存在
     *
     * @author yezi
     *
     * @param $objId
     * @param $objType
     * @return bool
     */
    public function checkObj($objId, $objType)
    {
        $obj = '';

        switch ($objType) {
            case 1:
                $obj = Post::query()->find($objId);
                break;
            case 2:
                $obj = SaleFriend::query()->find($objId);
                break;
            case 3:
                $obj = MatchLove::query()->find($objId);
                break;
            case 4:
                $obj = Comment::query()->find($objId);
                break;
            case 5:
                $obj = Praise::query()->find($objId);
                break;
        }

        return empty($obj) ? false : true;
    }

    /**
     * 获取用户消息列表
     *
     * @author yezi
     *
     * @param $userId
     * @param $type
     * @param $messageType
     * @param $pageParams
     * @return mixed
     */
    public function getInboxList($userId, $type, $messageType, $pageParams)
    {
        if ($messageType == 0) {
            $messageType = '';
        }

        $builder = Inbox::query()->with(['fromUser', 'toUser'])->where(Inbox::FIELD_ID_TO, $userId);
        if ($type == 0) {
            $builder->when($messageType, function ($query) {
                return $query->where(Inbox::FIELD_READ_AT, null);
            });
        } else {
            $builder->where(Inbox::FIELD_OBJ_TYPE, $type)
                ->when($messageType, function ($query) {
                    return $query->where(Inbox::FIELD_READ_AT, null);
                });
        }

        $builder->orderBy(Inbox::FIELD_CREATED_AT,'desc');

        $result = $this->paginateLogic->paginate($builder, $pageParams, '*');

        return $result;
    }

    public function readInbox($userId, $objType = null)
    {
        $result = Inbox::query()
            ->where(Inbox::FIELD_ID_TO, $userId)
            ->when($objType, function ($query) use ($objType) {
                $query->where(Inbox::FIELD_OBJ_TYPE, $objType);

                return $query;
            })
            ->update([Inbox::FIELD_READ_AT => Carbon::now()]);

        return $result;
    }

    /**
     * 检测用户是否有新的消息
     *
     * @author yezi
     *
     * @param $userId
     * @param $type
     * @return int
     */
    public function getNewInboxByType($userId, $type)
    {
        if ($type == 0) {
            $result = Inbox::query()
                ->where(Inbox::FIELD_ID_TO, $userId)
                ->where(Inbox::FIELD_READ_AT, null)
                ->count();
        } else {
            $result = Inbox::query()
                ->where(Inbox::FIELD_ID_TO, $userId)
                ->where(Inbox::FIELD_OBJ_TYPE, $type)
                ->where(Inbox::FIELD_READ_AT, null)
                ->count();
        }

        return $result;
    }

    public function formatInboxList($inboxList)
    {
        return collect($inboxList)->map(function ($inbox) {
            return $this->formatInbox($inbox);
        });
    }

    public function formatInbox($inbox)
    {
        $objType = $inbox->{Inbox::FIELD_OBJ_TYPE};
        $objId = $inbox->{Inbox::FIELD_ID_OBJ};

        $obj = $this->getObj($objId, $objType);

        $inbox->obj = $obj;

        $inbox->parentObj = !empty($obj) ? $this->getObj($obj->obj_id, $obj->obj_type) : null;

        return $inbox;
    }


    public function getObj($objId, $objType)
    {
        $obj = '';
        switch ($objType) {
            case 1:
                $obj = Post::query()->find($objId);
                break;
            case 2:
                $obj = SaleFriend::query()->find($objId);
                break;
            case 3:
                $obj = MatchLove::query()->find($objId);
                break;
            case 4:
                $obj = Comment::query()->find($objId);
                break;
            case 5:
                $obj = Praise::query()->find($objId);
                break;
        }

        return $obj;
    }

}