<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/17
 * Time: 下午10:14
 */

namespace App\Http\Logic;


use App\ChatMessage;
use App\Http\Repository\ChatRepository;
use Carbon\Carbon;

class ChatLogic
{
    protected $chatMessage;

    public function __construct(ChatRepository $chatRepository)
    {
        $this->chatMessage = $chatRepository;
    }

    /**
     * 发送好友消息
     *
     * @author yezi
     *
     * @param $fromId
     * @param $toId
     * @param $content
     * @param $attachments
     * @param $type
     * @param $post_at
     * @return mixed
     */
    public function sendMessage($fromId,$toId,$content,$attachments,$type,$post_at)
    {
        return $this->chatMessage->saveChatMessage($fromId,$toId,$content,$attachments,$type,$post_at);
    }

    public function chatList($userId,$friendId)
    {
        $result = $this->chatMessage->chatList($userId,$friendId);

        $result = collect($result)->map(function ($item){

            return $this->format($item);

        });

        $newMessages = collect($result)->filter(function ($item){

            if(empty($item->{ChatMessage::FIELD_READ_AT})){
                return true;
            }else{
                return false;
            }

        });
        $ids = collect(collect($newMessages)->pluck(ChatMessage::FIELD_ID))->toArray();

        $this->readMessage($ids);

        return $result;
    }

    /**
     * 阅读信息
     *
     * @param $ids
     * @return int
     */
    public function readMessage($ids)
    {
        return ChatMessage::query()->whereIn(ChatMessage::FIELD_ID,$ids)->update([ChatMessage::FIELD_READ_AT=>Carbon::now()]);
    }

    /**
     * 获取新消息
     *
     * @author yezi
     *
     * @param $userId
     * @param $friendId
     * @return static
     */
    public function newMessage($userId,$friendId)
    {
        $result = ChatMessage::query()
            ->where(function ($query)use($userId,$friendId){
                $query->where(ChatMessage::FIELD_ID_FROM_USER,$userId)
                    ->where(ChatMessage::FIELD_READ_AT,null)
                    ->where(ChatMessage::FIELD_ID_TO,$friendId);
            })->orWhere(function ($query)use($userId,$friendId){
                $query->where(ChatMessage::FIELD_ID_FROM_USER,$friendId)
                    ->where(ChatMessage::FIELD_READ_AT,null)
                    ->where(ChatMessage::FIELD_ID_TO,$userId);
            })->orderBy(ChatMessage::FIELD_CREATED_AT,'desc')->get();

        $result = collect($result)->map(function ($item){

            return $this->format($item);

        });

        $newMessages = collect($result)->filter(function ($item){

            if(empty($item->{ChatMessage::FIELD_READ_AT})){
                return true;
            }else{
                return false;
            }

        });
        $ids = collect(collect($newMessages)->pluck(ChatMessage::FIELD_ID))->toArray();

        $this->readMessage($ids);

        return $result;

    }

    /**
     * 格式化返回值
     *
     * @author yezi
     *
     * @param $message
     * @return mixed
     */
    public function format($message)
    {
        $message->fromUser;
        $message->toUser;

        return $message;
    }

}