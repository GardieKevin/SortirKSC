<?php

namespace App\Tests\Entity;

use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\User;
use Couchbase\Role;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testSomething(): void
    {
        $user = (new User())
            ->setFirstname('Kévin');
        $this->assertEquals('Kévin', $user->getFirstname());

        $user->setId('1');
        $this->assertEquals('1', $user->getId());

        $user->setLastname('Gardie');
        $this->assertEquals('Gardie', $user->getLastname());

        $user->setPassword('123456');
        $this->assertEquals('123456', $user->getPassword());

        $user->setEmail('gardie.kevin@gmail.com');
        $this->assertEquals('gardie.kevin@gmail.com', $user->getEmail());

        $user->setPseudo('Coco');
        $this->assertEquals('Coco', $user->getPseudo());

        $user->setPhone('0123456789');
        $this->assertEquals('0123456789', $user->getPhone());

        $user->setActiv(true);
        $this->assertEquals(true, $user->getActiv());

        $user->setActiv(false);
        $this->assertEquals(false, $user->getAdministrator());

        $user->setImage('image.jpg');
        $this->assertEquals('image.jpg', $user->getImage());

        $campus = new Campus();
        $user->setCampus($campus);
        $this->assertEquals($campus, $user->getCampus());

        $event = new Event();
        $this->assertEquals($event, $user->getEvents());

        $this->assertTrue(true);
    }
}
