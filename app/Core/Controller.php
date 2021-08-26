<?php 

namespace App\Core;



class Controller 
{


    /**
     * @var object
     */
    protected $telegram;


    /**
     * @var object
     */
    protected $info;


    /**
     * @var int
     */
    protected $userId;


    /**
     * @var int
     */
    protected $chatId;


    /**
     * @var string
     */
    protected $username;


    /**
     * @var string
     */
    protected $message;



    /**
     * Controller constructor
     */
    public function __construct()
    {
        $this->telegram = App::getTelegram();
        $this->info = $this->telegram->getWebhookUpdates();
        $this->userId = $this->info['message']['from']['id'];
        $this->chatId = $this->info['message']['chat']['id'];
        $this->username = $this->info['message']['from']['username'];
        $this->message = $this->info['message']['text'];
    }
}