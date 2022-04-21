<?php

namespace App\Controller;

use App\Repository\CampusRepository;
use App\Repository\EtatRepository;
use App\Repository\EventRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    #[Route('/', name: 'main_home')]
    public function home(
        EntityManagerInterface $entityManager,
        EtatRepository         $etatRepository,
        EventRepository        $eventRepository,
        CampusRepository        $campusRepository,

    ): Response
    {
        $listecampus = $campusRepository->findAll();

        $id = 3;
        $etatRepository->find($id);
        $today = new \DateTime('now');
        $archiveDate = 60;
        $events = $eventRepository->findAllEvents();
        foreach ($events as $e)
        {
                $eventDate = $e->getStartingDate();
                $limitDate = $e->getLimitInscribeDate();
                if ($e->getEtat()->getId() != 6)
                {

                    if ($today > $eventDate)
                    {
                        if ($today < $eventDate->modify('+ ' . $e->getDuration() . 'days'))
                        {
                            $id = 4;
                            $etat = $etatRepository->find($id);

                            $e->setEtat($etat);
                            $entityManager->persist($e);
                            $entityManager->flush();
                        } else
                        {
                            $id = 5;
                            $etat = $etatRepository->find($id);
                            $e->setEtat($etat);
                            $entityManager->persist($e);
                            $entityManager->flush();
                        }
                    }
                    if ($today < $eventDate)
                    {
                        if ($today < $limitDate)
                        {
                            $id = 2;
                            $etat = $etatRepository->find($id);
                            $e->setEtat($etat);
                            $entityManager->persist($e);
                            $entityManager->flush();
                        } else
                        {
                            $id = 3;
                            $etat = $etatRepository->find($id);
                            $e->setEtat($etat);
                            $entityManager->persist($e);
                            $entityManager->flush();
                        }
                    }
                }

                if($today> $eventDate->modify( '+' .$archiveDate))
                {
                    $id = 7;
                    $etat = $etatRepository->find($id);
                    $e->setEtat($etat);
                    $entityManager->persist($e);
                    $entityManager->flush();
}
                }

        return $this->render('main/home.html.twig',
            compact("events", "listecampus")
        );
    }
}

