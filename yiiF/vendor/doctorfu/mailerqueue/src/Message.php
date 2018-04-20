<?php
namespace doctorfu\mailerqueue;
use Yii;
class Message extends \yii\swiftmailer\Message
{
	public function queue(){
	   $redis = Yii::$app->redis;
	   if(empty($redis)){
	       throw new \yii\base\InvalidConfigException('redis not found');
       }
        $mailer = Yii::$app->mailer;
	   if(empty($mailer)||!$redis->select($mailer->db)){
           throw new \yii\base\InvalidConfigException('db not found');
       }
       $message=[];
	   $message['from']=$this->from;
	   $message['to']=$this->to;
	   $message['cc']=$this->cc;
	   $message['bcc']=$this->bcc;
	   $message['reply_to']=$this->getReplyto();
	   $message['charset']=$this->charset;
	   $message['subject']=$this->subject;
	   $parts = $this->getSwiftMessage()->getChildren();
	   if(!is_array($parts)||!sizeof($parts)){
	       $parts=[$this->getSwiftMessage()];
       }
        foreach ($parts as $part) {
            if (!$part instanceof \Swift_Mime_Attachment) {
                switch($part->getContentType()) {
                    case 'text/html':
                        $message['html_body'] = $part->getBody();
                        break;
                    case 'text/plain':
                        $message['text_body'] = $part->getBody();
                        break;
                }
                if (!$message['charset']) {
                    $message['charset'] = $part->getCharset();
                }
            }
        }
        return $redis->rpush($mailer->key, json_encode($message));
    }
}