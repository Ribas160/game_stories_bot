<?php

namespace App\Core;

use Dotenv\Dotenv;
use Telegram\Bot\Api;
use App\Controllers\AppController;

class App 
{


    /**
     * @return void
     */
    public function run(): void
    {
        set_exception_handler([$this, 'exceptionHandler']);

        $dotenv = Dotenv::createImmutable(__DIR__ . '/../../');
        $dotenv->load();
        
        $controller = new AppController();
        $controller->go();
    }



    /**
     * @return object
     */
    public static function getTelegram(): object
    {
        return new Api($_ENV['BOT_TOKEN']);
    }



    /**
     * @param string $alias
     * @return string
     */
    public static function getAlias(string $alias): string
    {
        $aliases = require __DIR__ . '/../../config/Aliases.php';
        return $aliases[$alias];
    }


    public static function log($message, $path = 'app'): bool
    {
        date_default_timezone_set('Europe/Moscow');

        $logs = self::getAlias('@logs') . $path;
        if (!file_exists($logs)) mkdir($logs, 0755, true);
        $filename = $logs . '/' . date('Y-m-d') . '.log';
        file_put_contents($filename, date('Y-m-d H:i:s ') . $message . PHP_EOL, FILE_APPEND);

        return true;
    }


    public function exceptionHandler($e)
    {
        self::log($e->getMessage());
    }
}