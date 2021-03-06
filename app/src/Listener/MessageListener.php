<?php


namespace App\Listener;


use App\Events\MessageEvent;

class MessageListener
{

    private function getHeader(mixed $data): string{
        if(is_array($data)){
            if(isset($data[0])) $result = $data[0];
            else $result = array_pop($data);
        }else{
            $result = $data;
        }
        return $result;
    }


    public function onPushMessage(MessageEvent $event){
        $r =  $event->getMessage() ; //here we get one message
        $channel = trim($event->getNotify()->getChannels()->getChatId());
        $token = trim($event->getNotify()->getBots()->getToken());
        if(gettype($r) === 'array'){
                $result_message = null;
                if(isset($r['url'])){
                    $result_message .=  '<a href="'.$r['url'].'">'. $this->getHeader($r['text']) .'</a>' . PHP_EOL;
                    if(is_array($r['text']))
                        $result_message .=  '<pre>'.  implode( PHP_EOL , $r['text'])  .'</pre>';
                }

                $link = [];
                $keyboard_array = [];
                foreach ($event->getNotify()->getBots()->getBotButtons() as $button){
                    if($button->getCallback() === 'link'){
                        $link =  ['text' => $button->getName() , 'url' => $r['url']];
                    }else{
                        array_push($keyboard_array , [ 'text' => $button->getName()  , 'callback_data' =>  $button->getCallback() . $event->getJobId() ]);
                    }
                }


                $keyboard = json_encode([
                    "inline_keyboard" => [
                        [
                            $link
                        ],
                        [
                            ...$keyboard_array
                        ]
                    ]
                ]);


                $data= [
                    'chat_id' => $channel,
                    'text' => $result_message,
                    'parse_mode' => 'html',
                    'reply_markup'=> $keyboard
                ];

                file_get_contents("https://api.telegram.org/bot$token/sendMessage?" . http_build_query($data ,'','&') );
        }
    }


}
