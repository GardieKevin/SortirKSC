<?php

namespace App\Tests\Entity;

use App\Entity\Etat;
use PHPUnit\Framework\TestCase;

class EtatTest extends TestCase
{
    public function testSomething(): void
    {
        $etat = (new Etat())
            ->setLibelle('Closed');
        $this->assertEquals('Closed', $etat->getLibelle());



        $this->assertTrue(true);
    }
}
