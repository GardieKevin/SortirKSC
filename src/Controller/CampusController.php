<?php

namespace App\Controller;

use App\Entity\Campus;
use App\Form\CampusType;
use App\Repository\CampusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CampusController extends AbstractController
{
    #[Route('/campus', name: 'campus_list')]
    public function list(
        CampusRepository $campusRepository
    ): Response
    {
        $campus = $campusRepository->findAll();
        return $this->render('campus/list.html.twig',
            compact("campus"));
    }

    #[Route('/campus/delete/{id}', name: 'campus_delete')]
    public function delete(
        Campus $campus,
        CampusRepository $campusRepository,
        EntityManagerInterface $em,
        Request $request, $id
    ): Response
    {
        $eventRepository = $em->getRepository(Campus::class);
        $campus = $campusRepository->find($id);
        $em->remove($campus);
        $em->flush();

        return $this->redirectToRoute('main_home');
    }

    #[Route('/campus/modify/{id}', name: 'campus_modify', requirements: ['id' => '^\d+'], methods: ['GET', 'POST'])]
    public function modify(
        int             $id,
        EntityManagerInterface $em,
        Request         $request,
        Campus           $campus,
        CampusRepository $cr,
    ): Response
    {
        $campus = $cr->find($id);
        $campusForm = $this->createForm(CampusType::class, $campus);
        $campusForm->handleRequest($request);

        $cr->add($campus);

        if ($campusForm->isSubmitted() && $campusForm->isValid()){
            $em->persist($campus);
            $em->flush();
            return $this->redirectToRoute('campus_list');
        }

        return $this->renderForm('campus/modify.html.twig',
            compact("campus", "campusForm")
        );
    }
    }
}
