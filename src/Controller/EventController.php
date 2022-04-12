<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventType;
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

    ): Response
    {
        $event = new Event();
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
}