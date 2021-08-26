<?php 

namespace Tests\Unit\Models;

use PHPUnit\Framework\TestCase;
use App\Models\Storage;

class StorageTest extends TestCase
{


    public function testCreateNewUser()
    {
        $storage = new Storage();
        $result = $storage->createNewUser(1, 2);
        $this->assertTrue($result);
    }


    public function testGetUserData()
    {
        $storage = new Storage();
        $storage->createNewUser(1, 2);
        $user = $storage->getUserData(1);
        $this->assertIsArray($user);
        $this->assertNotEmpty($user);
    }

}