<?php

namespace App\Controller;

use App\Entity\Campus;
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
}
