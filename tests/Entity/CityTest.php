<?php

namespace App\Tests\Entity;

use App\Entity\City;
use PHPUnit\Framework\TestCase;

class CityTest extends TestCase
{
    public function testSomething(): void
    {
        $city = (new City())
            ->setStreet('Boulevard Jules Verne');
        $this->assertEquals('Boulevard Jules Verne', $city->getStreet());

        $city->setPostcode('44300');
        $this->assertEquals('44300', $city->getPostcode());

        $city->setName('Nantes');
        $this->assertEquals('Nantes', $city->getName());

        $city->setId('1');
        $this->assertEquals('1', $city->getId());

        $this->assertTrue(true);
    }
}
