<?php 

namespace App\Models;

use App\Core\App;

class Storage 
{



    /**
     * @var string
     */
    private $storageFile;


    /**
     * @var array
     */
    private $storage;



    /**
     * Storage constructor
     */
    public function __construct()
    {
        $this->getStorageData();
    }


    /**
     * @param int $userId
     * @return array
     */
    public function getUserData(int $userId): array
    {
        foreach ($this->storage as $user) {
            if ($userId === $user['id']) return $user;
        }

        return [];
    }


    /**
     * @param int $userId
     * @param int $chatId
     */
    public function createNewUser(int $userId, int $chatId): bool
    {
        $user = [
            'id' => $userId,
            'chat' => $chatId,
            'story' => '',
        ];

        $this->storage[] = $user;

        if (file_put_contents($this->storageFile, json_encode($this->storage))) {
            $this->getStorageData();
            return true;
        } else return false;
    }



    /**
     * @param int $userId
     * @param array $data
     */
    public function setUserData(int $userId, array $data)
    {
        foreach ($this->storage as $key => $user) {
            if ($user['id'] === $userId) {
                foreach ($data as $param => $value) $this->storage[$key][$param] = $value;
            }
        }
        
        file_put_contents($this->storageFile, json_encode($this->storage));
        $this->getStorageData();
    }


    /**
     * @return void
     */
    private function getStorageData(): void
    {
        $this->storageFile = App::getAlias('@storage');
        if (file_exists($this->storageFile)) $this->storage = json_decode(file_get_contents($this->storageFile), true);
        else $this->storage = [];
    }
}