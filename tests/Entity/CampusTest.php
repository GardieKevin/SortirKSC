<?php

namespace App\Tests\Entity;

use App\Entity\Campus;
use App\Entity\Event;
use App\Entity\User;
use PHPUnit\Framework\TestCase;

class CampusTest extends TestCase
{
    public function testSomething(): void
    {
        $campus = (new Campus())
            ->setName('Nantes');
        $this->assertEquals('Nantes', $campus->getName());

        $campus->setPostcode('44000');
        $this->assertEquals('44000', $campus->getPostcode());

        $campus->setId('1');
        $this->assertEquals('1', $campus->getId());

        $user = new User();
        $campus->getUsers($user);

        $users = array(User::class);


        $event = new Event();
        $campus->getEvents($event);

        $this->assertTrue(true);
    }
}
