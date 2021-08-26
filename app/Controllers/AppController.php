<?php 

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Storage;
use App\Models\Story;
use App\Services\ResponseService;


class AppController extends Controller
{


    public function go()
    {
        $storage = new Storage();
        $story = new Story();
        $response = new ResponseService($this->telegram);

        $user = $storage->getUserData($this->userId);
        if (!$user) {
            $storage->createNewUser($this->userId, $this->chatId);
            $user = $storage->getUserData($this->userId);
        }
        
        if ($this->message !== $user['lastMessage']) {
            $storage->setUserData($this->userId, ['lastMessage' => $this->message]);

            if ($this->message === '/start') $response->greating($user);
            else if (in_array($this->message, $story->getStoriesList())) {
                $storage->setUserData($this->userId, ['story' => $this->message]);
                $user = $storage->getUserData($this->userId);
                $story->tellStory($user, $this->telegram, 'start');
            } else {
                $story->tellStory($user, $this->telegram, $this->message);
            }
        }
    }

}