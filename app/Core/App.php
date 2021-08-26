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
    public static function run(): void
    {
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
}