<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{

//    #[Route('/event', name: 'app_event')]
//    public function index(): Response
//    {
//        return $this->render('event/index.html.twig', [
//            'controller_name' => 'EventController',
//        ]);
//    }

    #[Route('/create', name: 'event_create')]
    public function create(

        Request $request,
        EntityManagerInterface $em,
        UserRepository $ur,

    ): Response
    {
        $event = new Event();

        $user = $this->getUser();
        $currentUser = $ur->findOneBy(['pseudo' => $user->getUserIdentifier()]);
        $event->setOrganisator($currentUser);

        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()){
            $em->persist($event);
            $em->flush();
            $this->addFlash('info', 'Event successfully created !');
            return $this->redirectToRoute('main_home');
        }

        return $this->render(
            'event/create.html.twig',
            ['myForm' => $eventForm->createView()]
        );
    }

    #[Route('/event/detail/{id}', name: 'event_detail')]
    public function detail(

        EventRepository $eventRepository,
        Event           $event
    ): Response
    {
        return $this->render('event/detail.html.twig',
            compact("event")
        );
    }

    #[Route('/event/modify/{id}', name: 'event_modify', requirements: ['id'=>'^\d+'], methods: ['GET', 'POST'])]
    public function modify(
        //TODO methode modify pour les events

        EventRepository $eventRepository,
        Event           $event
    ): Response
    {
        return $this->render('event/modify.html.twig',
            compact("event")
        );
    }
}
