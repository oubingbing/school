<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/15
 * Time: 下午12:02
 */

namespace App\Http\Logic;


use App\Exceptions\ApiException;
use App\Http\Repository\CommentRepository;
use App\Http\Repository\InboxRepository;
use App\Http\Repository\MatchLoveRepository;
use App\Http\Repository\PostRepository;
use App\Http\Repository\PraiseRepository;
use App\Http\Repository\SaleFriendRepository;
use App\Http\Repository\UserRepository;
use App\Inbox;

class InboxLogic
{
    protected $inboxRepository;
    protected $userRepository;
    protected $postRepository;
    protected $saleFriendRepository;
    protected $matchLoveRepository;
    protected $commentRepository;
    protected $praiseRepository;

    public function __construct(InboxRepository $inboxRepository,UserRepository $userRepository,PostRepository $postRepository,SaleFriendRepository $friendRepository,MatchLoveRepository $matchLoveRepository,CommentRepository $commentRepository,PraiseRepository $praiseRepository,SaleFriendRepository $saleFriendRepository)
    {
        $this->inboxRepository = $inboxRepository;
        $this->userRepository = $userRepository;
        $this->postRepository = $postRepository;
        $this->saleFriendRepository = $saleFriendRepository;
        $this->matchLoveRepository = $matchLoveRepository;
        $this->commentRepository = $commentRepository;
        $this->praiseRepository = $praiseRepository;
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
    public function send($fromId,$toId,$objId,$content,$objType,$actionType,$postAt)
    {
        $fromUser = $this->userRepository->getUserById($fromId);
        $toUser = $this->userRepository->getUserById($toId);

        if (!$fromUser)
            throw new ApiException('用户不存在',404);

        if(!$toUser)
            throw new ApiException('用户不在',404);

        $checkResult = $this->checkObj($objId,$objType);
        if (!$checkResult)
            throw new ApiException('对象不存在',404);

        $result = $this->inboxRepository->store($fromId, $toId, $objId, $content, $objType, $actionType, $postAt);

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
    public function checkObj($objId,$objType)
    {
        $obj = '';

        switch ($objType){
            case 1:
                $obj = $this->postRepository->getPostById($objId);
                break;
            case 2:
                $obj = $this->saleFriendRepository->getSaleFriendById($objId);
                break;
            case 3:
                $obj = $this->matchLoveRepository->getMatchLoveById($obj);
                break;
            case 4:
                $obj = $this->commentRepository->getCommentById($objId);
                break;
            case 5:
                $obj = $this->praiseRepository->getPraiseById($objId);
                break;
        }

        return empty($obj)?false:true;
    }

    /**
     * 获取用户消息列表
     *
     * @author yezi
     *
     * @param $userId
     * @param $type
     * @param $messageType
     * @return mixed
     */
    public function getInboxList($userId,$type,$messageType)
    {
        if($messageType == 0){
            $messageType = '';
        }

        return $this->inboxRepository->userInbox($userId,$type,$messageType);
    }

    public function readInbox($userId,$objType=null)
    {
        return $this->inboxRepository->readInbox($userId,$objType);
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
    public function getNewInboxByType($userId,$type)
    {
        return $this->inboxRepository->countNewInboxByType($userId,$type);
    }

    public function formatInboxList($inboxList)
    {
        return collect($inboxList)->map(function ($inbox){
            return $this->formatInbox($inbox);
        });
    }

    public function formatInbox($inbox)
    {
        $objType = $inbox->{Inbox::FIELD_OBJ_TYPE};
        $objId = $inbox->{Inbox::FIELD_ID_OBJ};

        $obj = $this->getObj($objId,$objType);

        $inbox->obj = $obj;

        $inbox->parentObj = !empty($obj)?$this->getObj($obj->obj_id,$obj->obj_type):null;

        return $inbox;
    }


    public function getObj($objId,$objType)
    {
        $obj = '';
        switch ($objType){
            case 1:
                $obj = $this->postRepository->getPostById($objId);
                break;
            case 2:
                $obj = $this->saleFriendRepository->getSaleFriendById($objId);
                break;
            case 3:
                $obj = $this->matchLoveRepository->getMatchLoveById($obj);
                break;
            case 4:
                $obj = $this->commentRepository->getCommentById($objId);
                break;
            case 5:
                $obj = $this->praiseRepository->getPraiseById($objId);
                break;
        }

        return $obj;
    }

}