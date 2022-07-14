<?php


namespace App\Listener;


use App\Events\MessageEvent;

class MessageListener
{

    public function onPushMessage(MessageEvent $event){
        $result =  json_decode($event->getMessage() , 'true');
        $channel = trim($event->getNotify()->getChannels()->getChatId());
        $token = trim($event->getNotify()->getBots()->getToken());

        if(gettype($result) === 'array'){
            foreach ($result   as $r){
                $result_message = null;
                if(isset($r['url'])){
                    $result_message .=  '<a href="'.$r['url'].'">'. $r['text'][0] .'</a>' . PHP_EOL;
                    $result_message .=  '<pre>'. implode( PHP_EOL ,$r['text']) .'</pre>';
                }


                $keyboard = json_encode([
                    "inline_keyboard" => [
                        [
                            [
                                "text" => "No",
                                "callback_data" => "no"
                            ]

                        ],

                        [
                            [
                                    "text" => "No",
                                    "callback_data" => "no"
                            ],
                            [
                                    "text" => "Stop",
                                    "callback_data" => "stop"
                            ]
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
                die();
            }

        }
    }


}
