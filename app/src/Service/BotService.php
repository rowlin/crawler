<?php


namespace App\Service;


use App\Entity\Bot;
use App\Exception\NotFoundException;
use App\Repository\BotRepository;
use App\Requests\BotCreateRequest;
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

    public function actionWithManualUpdate(string $token , string $status) : array{
        $result = ['message' => 'Bot not found'];
        if($this->checkTokenAvailable($token)){
            if( $status === 'start') {
                $response = $this->client->request('GET' ,"https://api.telegram.org/bot$token/getUpdates");
                $result = $response->getContent();
            }else{
                $result = ['message' => 'status not found'];
            }
        }
        return $result;
    }

    public function getUpdate(string $token , Request $request ) : array{
        $result = ['message' => 'Bot not found'];
        if($this->checkTokenAvailable($token)){
            $result = ['message' => "Ok"];

        }
        return $result;
    }


    /**
     * {@inheritdoc}
     * @return array
     */

    public function getBotTokens(): array{
        return $this->cache->get("bot_tokens",
            function (ItemInterface $item) {
                return $this->botRepository->selectTokensList();
            });
    }

    public function getBots() :array{
        return $this->botRepository->findAll();
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

    public function update(BotCreateRequest $request , $id): array{
        $current_bot =  $this->botRepository->findOneBy(['id' => $id]);
        if(!$current_bot)
            throw new NotFoundException("Bot not found");
        else {
            $current_bot->setName($request->getName());
            $current_bot->setToken($request->getToken());
            $current_bot->setActive($request->getActive());
            $current_bot->setIsWebhook($request->getIsWebhook());
            $this->botRepository->add($current_bot, true);
            $this->deleteTokensfromCache();
        }
        return ['message' => "Job updated" , 'data' => $this->getBots()];
    }

}
