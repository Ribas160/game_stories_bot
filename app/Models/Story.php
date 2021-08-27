<?php 

namespace App\Models;

use App\Core\App;
use App\Services\ResponseService;

class Story 
{

    
    /**
     * @var array
     */
    private $stories;



    /**
     * Story constructor
     */
    public function __construct()
    {
        $this->stories = require App::getAlias('@stories');
    }


    /**
     * @param array $user
     * @param object $telegram
     * @param string $message
     */
    public function tellStory(array $user, object $telegram, string $answer)
    {
        $response = new ResponseService($telegram);
        $story = $this->getStory($user['story']);
        $message = [];

        if (isset($story[$answer]['message'])) $message = self::parseStory($story[$answer]['message']);

        $end = 0;
        if (isset($story[$answer]['choice'])) $end = 1;
        for ($i=0; $i < count($message) - $end; $i++) { 
            $response->sendMessage($user, $message[$i]);
            sleep(4);
        }
        if (isset($story[$answer]['choice'])) $response->sendChoice($user, $story[$answer]['choice'], end($message));
        if (isset($story[$answer]['jump'])) $this->tellStory($user, $telegram, $story[$answer]['jump']);
    }



    /**
     * @return array
     */
    public function getStoriesList(): array
    {
        $list = [];
        foreach ($this->stories as $story) $list[] = $story['name'];
        return $list;
    }


    /**
     * @param string
     * @return array
     */
    public function getStory(string $name): array
    {
        foreach ($this->stories as $story) {
            if ($story['name'] === $name) return $story;
        }

        return [];
    }


    /**
     * @param string $storyName
     * @return $array
     */
    public function getStoryParts(string $storyName): array
    {
        $story = $this->getStory($storyName);

        if (!$story) return [];

        $parts = array_keys($story);
        unset($parts['name']);

        return $parts;
    }


    /**
     * @param string
     * @return array
     */
    private static function parseStory(string $message): array
    {
        $clear = [];
        $text = explode("\n", $message);
        foreach ($text as $string) {
            if (trim($string)) $clear[] = $string;
        }

        return $clear;
    }

}