<?php
/**
 * Created by PhpStorm.
 * User: xuxiaodao
 * Date: 2017/12/17
 * Time: 下午10:14
 */

namespace App\Http\Logic;


use App\Http\Repository\ChatRepository;

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
     */
    public function sendMessage($fromId,$toId,$content,$attachments,$type,$post_at)
    {
        $this->chatMessage->saveChatMessage($fromId,$toId,$content,$attachments,$type,$post_at);
    }

}