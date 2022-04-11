<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/event', name: 'event_list')]
    public function list(
        EventRepository $eventRepository
    ): Response
    {
        $events = $eventRepository->findAllEvents();
        return $this->render('event/list.html.twig',
            compact("events")
        );
    }


}
