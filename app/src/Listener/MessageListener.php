<?php


namespace App\Listener;


use App\Events\MessageEvent;
use App\Message\TelegramNotification;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DelayStamp;

class MessageListener
{

    public function __construct(private MessageBusInterface $messageBus)
    {
    }

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
        $r_job_id = $event->getJobId();
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
                $keyboard_link = [];

                foreach ($event->getNotify()->getBots()->getBotButtons() as $button){
                    if($button->getCallback() === 'link'){
                        $link =  ['text' => $button->getName() , 'url' => $r['url']];
                    }else{
                        array_push($keyboard_array , [ 'text' => $button->getName()  , 'callback_data' =>  $button->getCallback() . $event->getJobId() ]);
                    }
                }


                if(!empty($link)) {
                    $keyboard_link =[
                        "inline_keyboard" => [
                            [
                                $link
                            ]
                        ]
                    ];
                }
                if(!empty($keyboard_array)){
                    if(!isset($keyboard_link["inline_keyboard"])){
                        $keyboard_link["inline_keyboard"] = [];
                    }


                    array_push( $keyboard_link["inline_keyboard"] , [
                        ...$keyboard_array
                    ]);
                }
                if(!empty($keyboard_link)){
                    $keyboard = json_encode($keyboard_link);
                }

                $data= [
                    'chat_id' => $channel,
                    'text' => $result_message,
                    'parse_mode' => 'html',
                    'reply_markup'=> $keyboard ?? null
                ];
                $this->messageBus->dispatch(new TelegramNotification($token , $r_job_id, $data ) );
        }

    }


}
