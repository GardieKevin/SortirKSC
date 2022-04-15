<?php

namespace App\Controller;

use App\Entity\Event;
use App\Repository\EtatRepository;
use App\Repository\EventRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use function MongoDB\BSON\toJSON;
use function Sodium\add;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function home(
        EntityManagerInterface $entityManager,
        EtatRepository  $etatRepository,
        EventRepository $eventRepository,
//        Event           $event,
    ): Response
    {

        $id=3;
        $etat = $etatRepository->find($id);

        $events = $eventRepository->findAllEvents();
        foreach ($events as $e){
        if (new \DateTime('now') > $e->getStartingDate())
            {$id=3;
                $etat = $etatRepository->find($id);

                $e->setEtat($etat);
                $entityManager->persist($e);
                $entityManager->flush();
            }
//        if(new \DateTime('now') > $e->getStartingDate() and (new \DateTime('now'))->date_add($e->getDuration()) < $e->getStartingDate())
//        {
//            $id=4;
//            $etat = $etatRepository->find($id);
//            $e->setEtat($etat);
//            $entityManager->persist($e);
//            $entityManager->flush();
//        }
        }
        return $this->render('main/home.html.twig',
            compact("events")
        );
    }

}