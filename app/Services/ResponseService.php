<?php 

namespace App\Services;

use App\Models\Story;
use Telegram\Bot\Keyboard\Keyboard;

class ResponseService
{


    /**
     * @var object
     */
    private $telegram;



    public function __construct(object $telegram)
    {
        $this->telegram = $telegram;
    }



    /**
     * @param object $telegram
     * @param array $user
     */
    public function greating(array $user)
    {
        $story = new Story();
        $stories = $story->getStoriesList();
        $keyboard = [];
        foreach ($stories as $storyName) $keyboard[] = [$storyName];

        $this->sendMessage($user, 'Добро пожаловать в StoryBot!');
        sleep(1);
        $this->sendKeyboard($user, $keyboard, 'Выберите историю, которую хотели бы пройти.');
    } 



    /**
     * @param array $user
     * @param array $keyboard
     * @param string $message
     */
    public function sendKeyboard(array $user, array $keyboard, string $message): void
    {
        $reply_markup = Keyboard::make([
            'keyboard' => $keyboard, 
            'resize_keyboard' => true, 
            'one_time_keyboard' => true,
        ]);

        $this->telegram->sendMessage([
            'chat_id' => $user['chat'],
            'text' => $message, 
            'reply_markup' => $reply_markup,
            'parse_mode' => 'HTML',
        ]);
    }



    /**
     * @param array $user
     * @param array $string
     */
    public function sendMessage(array $user, string $message): void
    {
        $this->telegram->sendMessage([
            'chat_id' => $user['chat'],
            'text' => $message,
            'parse_mode' => 'HTML',
        ]);
    }



    /**
     * @param array $user
     * @param array $choices
     * @param string $message
     */
    public function sendChoice(array $user, array $choices, string $message)
    {
        $keyboard = [];
        foreach ($choices as $choice) $keyboard[] = [$choice];
        $this->sendKeyboard($user, $keyboard, $message);
    }
}