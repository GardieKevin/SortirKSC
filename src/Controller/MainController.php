<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Entity\Event;
use App\Repository\CampusRepository;
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
        EtatRepository         $etatRepository,
        EventRepository        $eventRepository,
        CampusRepository        $campusRepository,

    ): Response
    {
        $listecampus = $campusRepository->findAll();

        $id = 3;
        $etat = $etatRepository->find($id);
        $today = new \DateTime('now');
        $archiveDate = 60;
        $events = $eventRepository->findAllEvents();
//        dd($events);
        foreach ($events as $e)
        {
                $eventDate = $e->getStartingDate();
                $limitDate = $e->getLimitInscribeDate();
                if ($eventEtat = $e->getEtat()->getId() != 6)
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
//                     $myVariableCSV = "id; name; startingDate; duration; limiteInscribeDate; maxInscriptionsNumber; information; organisator; campus; etat; participants\n";
//                     //Ajout de données (avec le . devant pour ajouter les données à la variable existante)
//                     $myVariableCSV .= serialize($e);
//                     //On donne la variable en string à la response, nous définissons le code HTTP à 200
//
//                return new Response
//                    (
//                        $myVariableCSV,
//                        200,
//                        [
//                            //Définit le contenu de la requête en tant que fichier Excel
//                            'Content-Type' => 'application/vnd.ms-excel',
//                            //On indique que le fichier sera en attachment donc ouverture de boite de téléchargement ainsi que le nom du fichier
//                            "Content-disposition" => "filename=backup.csv"
//                        ]
//                    );
}
                }

        return $this->render('main/home.html.twig',
            compact("events", "listecampus")
        );
    }
}

