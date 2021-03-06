<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Event;
use App\Form\EventType;
use App\Repository\CityRepository;
use App\Repository\EtatRepository;
use App\Repository\EventRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EventController extends AbstractController
{
    #[Route('/create', name: 'event_create')]
    public function create(
        Request                $request,
        EntityManagerInterface $em,
        UserRepository         $ur,
        CityRepository         $cr,

    ): Response
    {
        $event = new Event();
        $user = $this->getUser();

        $currentUser = $ur->findOneBy(['pseudo' => $user->getUserIdentifier()]);

        $event->setOrganisator($currentUser);

        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        if ($eventForm->isSubmitted() && $eventForm->isValid()) {
            $city = new City();
            $city->setName($request->get('postcode'));
            $city->setPostcode($request->get('searchPostCode'));
            $city->setStreet($request->get('street'));
            $cr->add($city);
            $event->setCity($city);
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
        Event           $event
    ): Response
    {

        return $this->render('event/detail.html.twig',
            compact("event")
        );
    }

    #[Route('/event/modify/{id}', name: 'event_modify', requirements: ['id' => '^\d+'], methods: ['GET', 'POST'])]
    public function modify(
        int             $id,
        EntityManagerInterface $em,
        Request         $request,
        EventRepository $er,
        CityRepository         $cr
    ): Response
    {
        $event = $er->find($id);
        $eventForm = $this->createForm(EventType::class, $event);
        $eventForm->handleRequest($request);

        $er->add($event);

        if ($eventForm->isSubmitted() && $eventForm->isValid()){
            $city = new City();
            $city->setName($request->get('postcode'));
            $city->setPostcode($request->get('searchPostCode'));
            $city->setStreet($request->get('street'));
            $cr->add($city);
            $event->setCity($city);
            $em->persist($event);
            $em->flush();
            return $this->redirectToRoute('main_home');
        }

        return $this->renderForm('event/modify.html.twig',
            compact("event", "eventForm")
        );
    }

    #[Route('/event/{event}/registration/', name: 'event_registration')]
    public function eventAddUser(
        Event $event,
        UserRepository $ur,
        EntityManagerInterface $em,
    ): Response
    {
            $user = $ur->findOneBy(['pseudo' => ($this->getUser()->getUserIdentifier())]);
            $event->addParticipant($user);

            $em->persist($event);
            $em->flush($event);
            return $this->redirectToRoute('user_index');

    }

    #[Route('/event/{event}/remove/', name: 'event_remove')]
    public function eventRemoveUser(
        Event $event,
        UserRepository $ur,
        EntityManagerInterface $em,
    ): Response
    {
        $user = $ur->findOneBy(['pseudo'=>($this->getUser()->getUserIdentifier())]);
        $event->removeParticipant($user);
        $em->persist($event);
        $em->flush($event);
        return $this->redirectToRoute('user_index');
    }

    #[Route('/event/close/{id}', name: 'event_close')]
    public function eventCloser(
        Event $event,
        EtatRepository $etr,
        EntityManagerInterface $em,
    ): Response
    {

        $id2=6;
        $etat=$etr->find($id2);
        $event->setEtat($etat);
        $em->persist($event);
        $em->flush();
        return $this->redirectToRoute('user_index');
    }

    #[Route('/event/delete/{id}', name: 'event_delete')]
    public function delete(
        EntityManagerInterface $em,
        Request $id
    ): Response
    {
        $eventRepository = $em->getRepository(Event::class);
        $event = $eventRepository->find($id);
        $em->remove($event);
        $em->flush();

        return $this->redirectToRoute('main_home');
    }

}
