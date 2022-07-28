<?php


namespace App\Service;


use App\Entity\Bot;
use App\Entity\BotButtons;
use App\Exception\NotFoundException;
use App\Model\BotListItem;
use App\Model\BotListResponse;
use App\Repository\BotRepository;
use App\Requests\BotCreateRequest;
use App\Requests\BotUpdateRequest;
use phpDocumentor\Reflection\DocBlock\Tags\Return_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class BotService
{

    public function __construct(private BotRepository $botRepository ,  private CacheInterface $cache , private HttpClientInterface $client  ){
    }


    public function checkTokenAvailable(string $token) : bool{
       return  in_array( $token   , $this->getBotTokens());
    }

    public function deleteTokensfromCache(): bool{
        return $this->cache->delete('bot_tokens');
    }

    public function actionWithManualUpdate(string $token , string $status) //: array
    {
        $result = ['message' => 'Bot not found'];
        if($this->checkTokenAvailable($token)){
            if( $status === 'update') {
                $response = $this->client->request('GET' ,"https://api.telegram.org/bot$token/getUpdates");
                $result = json_decode($response->getContent() , true);
            }else{
                $result = ['message' => 'Status not found'];
            }
        }
        return $this->catchCallback($result);
    }

    protected function catchCallback(array $result){

       if(isset($result['ok']) & $result['ok'] & isset($result['result']) ){
           foreach ( $result['result'] as $r) {

               if (isset($r['callback_query']['data'])) {
                   dd($r['callback_query']['data']);
               }
           }
      }
    }



    public function getUpdate(string $token , Request $request ) : array{
        $result = ['message' => 'Bot not found'];
        if($this->checkTokenAvailable($token)){
            $result = ['message' => "Ok"];

        }
        return $result;
    }


    /**
     * {@inherit}
     * @return array
     *
     */

    public function getBotTokens(): array{
        return $this->cache->get("bot_tokens",
            function (ItemInterface $item) {
                return $this->botRepository->selectTokensList();
            });
    }


    public function getBots() : BotListResponse{
        return new BotListResponse(
            array_map( function (Bot $bot) : BotListItem{
            return new BotListItem(
                $bot->getId(),
                $bot->getName(),
                $bot->getToken(),
                $bot->isActive(),
                $bot->getIsWebhook(),
                $bot->getBotButtons(),
            );
        } ,$this->botRepository->findAll()));
    }

    public function create(BotCreateRequest $request) : array{
        $bot = new Bot();
        $bot->setToken($request->getToken());
        $bot->setName($request->getName());
        $bot->setActive($request->getActive());
        $bot->setIsWebhook(false);
        $this->botRepository->add($bot , true);
        $this->deleteTokensfromCache();
        return ['message' => "Bot was added"];
    }

    public function delete($id): array{
        $current_bot =  $this->botRepository->findOneBy(['id' => $id]);
        if(!$current_bot)
            throw new NotFoundException("Bot not found");
        else {
            $this->deleteTokensfromCache();
            $this->botRepository->remove($current_bot, true);
        }
        return ['message' => "Bot was deleted" , 'data' => $this->getBots()];
    }

    public function update(BotUpdateRequest $request , $id): array{
        $current_bot =  $this->botRepository->findOneBy(['id' => $id]);
        if(!$current_bot)
            throw new NotFoundException("Bot not found");
        else {
            $current_bot->setName($request->getName());
            $current_bot->setToken($request->getToken());
            $current_bot->setActive($request->getActive());
            $current_bot->setIsWebhook($request->getIsWebhook());
            $botButtons  = $request->getBotButtons();
            if(!empty($botButtons)){
                foreach ($botButtons as $button){
                    if(!isset($button['id'])){
                        $new_button  = new BotButtons();
                        $new_button->setName($button['name']);
                        $new_button->setCallback($button['callback']);
                        $current_bot->addBotButton($new_button);

                    }

                }
            }

            $this->botRepository->add($current_bot, true);
            $this->deleteTokensfromCache();
        }
        return ['message' => "Job updated" , 'data' => $this->getBots()];
    }

}
