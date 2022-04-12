<?php

namespace App\Controller;

use App\Repository\EventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_home')]
    public function home(
        EventRepository $eventRepository
    ): Response
    {
        $events = $eventRepository->findAllEvents();
        return $this->render('main/home.html.twig',
            compact("events")
        );
    }
}