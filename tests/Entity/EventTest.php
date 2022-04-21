<?php

namespace App\Tests\Entity;

use App\Entity\Campus;
use App\Entity\City;
use App\Entity\Etat;
use App\Entity\Event;
use App\Entity\User;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Validator\Constraints\DateTime;

class EventTest extends TestCase
{
    /**
     * @throws \Exception
     */
    public function testSomething(): void
    {
        $event = (new Event())
            ->setName('Apero');
        $this->assertEquals('Apero', $event->getName());

        $event->setId('1');
        $this->assertEquals('1', $event->getId());

        $event->setDuration('60');
        $this->assertEquals('60', $event->getDuration());

        $event->setInformations('Blabla');
        $this->assertEquals('Blabla', $event->getInformations());

        $event->setMaxInscriptionsNumber('10');
        $this->assertEquals('10', $event->getMaxInscriptionsNumber());

        $dateLimit = new \DateTime(2022-04-14);
        $event->setLimitInscribeDate($dateLimit);
        $this->assertEquals($dateLimit, $event->getLimitInscribeDate());

        $dateStart = new \DateTime(2022-05-20);
        $event->setStartingDate($dateStart);
        $this->assertEquals($dateStart, $event->getStartingDate());

        $organisator = new User();
        $event->setOrganisator($organisator);
        $this->assertEquals($organisator, $event->getOrganisator());

        $campus = new Campus();
        $event->setCampus($campus);
        $this->assertEquals($campus, $event->getCampus());

        $etat = new Etat();
        $event->setEtat($etat);
        $this->assertEquals($etat, $event->getEtat());

        $city = new City();
        $event->setCity($city);
        $this->assertEquals($city, $event->getCity());

        $this->assertTrue(true);
    }
}
