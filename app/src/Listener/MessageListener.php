<?php


namespace App\Listener;


use App\Events\MessageEvent;

class MessageListener
{

    public function onPushMessage(MessageEvent $event){
        $result =  json_decode($event->getMessage() , 'true');
        if(gettype($result) === 'array'){
            foreach ($result   as $r){
                $result_message = "";
                if(isset($r['url'])){
                    $result_message .= "<a href='" . $r['url'] . "'>".  $r['text'][0] ?? "<b>text not found</b>" ."</a>";
                }

                if(isset($r['text'])){
                    $result_message .= "<pre>". implode( '<br/>' ,$r['text']) ."</pre>";
                }

                dd($result_message);
            }

        }
    }


}
