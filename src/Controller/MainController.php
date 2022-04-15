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
        foreach ($events as $e) {
            $eventDate = $e->getStartingDate();
            $today=new \DateTime('now');
            $limitDate = $e->getLimitInscribeDate();
//            dd($date->modify('+ '.$e->getDuration().'days'));
            if ($today> $eventDate)
            {
                if ($today < $eventDate->modify('+ ' . $e->getDuration() . 'days')) {
                    $id = 4;
                    $etat = $etatRepository->find($id);

                    $e->setEtat($etat);
                    $entityManager->persist($e);
                    $entityManager->flush();
                }
                else{
                    $id = 5;
                    $etat = $etatRepository->find($id);
                    $e->setEtat($etat);
                    $entityManager->persist($e);
                    $entityManager->flush();
                }
            }
            if($today<$eventDate) {
                if ($today < $limitDate)
                {
                    $id = 2;
                    $etat = $etatRepository->find($id);
                    $e->setEtat($etat);
                    $entityManager->persist($e);
                    $entityManager->flush();
                }

                else
                {
                    $id = 3;
                    $etat = $etatRepository->find($id);
                    $e->setEtat($etat);
                    $entityManager->persist($e);
                    $entityManager->flush();
                }
            }
        }
        return $this->render('main/home.html.twig',
            compact("events")
        );
    }

}