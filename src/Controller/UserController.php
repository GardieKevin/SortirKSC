<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Integer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class UserController extends AbstractController
{
    #[Route('/', name: 'user_index')]
    public function index(): Response
    {
        return $this->render('user/detail.html.twig');

    }

    #[Route('/users', name: 'user_list')]
    public function list(
        UserRepository  $userRepository
    ): Response
    {
        $listeUsers = $userRepository->findAll();
        return $this->render('user/list.html.twig',
            compact("listeUsers"));

    }

    #[Route('/user/delete/{id}', name: 'user_delete')]
    public function delete(
        User $user,
        UserRepository $userRepository,
        EntityManagerInterface $em,
        Request $request, $id
    ): Response
    {
        $userRepository = $em->getRepository(User::class);
        $user = $userRepository->find($id);
        $em->remove($user);
        $em->flush();

        return $this->redirectToRoute('main_home');
    }


    #[Route('/user/{id}', name: 'user_detail')]
    public function detail(
        int            $id,
        User           $user,
        UserRepository $ur
    ): Response
    {
        $user = $ur->find($id);
        if (!$user) {
            throw $this->createNotFoundException('No user found');
        }
        return $this->render(
            'user/detail.html.twig',
            compact('user'));
    }

    #[Route('/user/edit/{id}', name: 'user_edit', methods: ['GET', 'POST'], requirements: ['id'=>'^\d+'])]
    public function edit(
        Int            $id,
        Request        $request,
        User           $user,
        UserRepository $ur,
        SluggerInterface $slugger,
        UserPasswordHasherInterface $userPasswordHasher
    ): Response
    {
        $user = $ur->find($id);
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $photo = $form->get('photo')->getData();

        // this condition is needed because the 'brochure' field is not required
        // so the PDF file must be processed only when a file is uploaded
        if ($photo) {
            $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
            // this is needed to safely include the file name as part of the URL
            $safeFilename = $slugger->slug($originalFilename);
            $newFilename =$user.'.'.$photo->guessExtension();

            // Move the file to the directory where brochures are stored
            try {
                $photo->move(
                    $this->getParameter('user_directory'),
                    $newFilename
                );
            } catch (FileException $e) {
                // ... handle exception if something happens during file upload
            }

            // updates the 'brochureFilename' property to store the PDF file name
            // instead of its contents
            $user->setImage($newFilename);
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $ur->add($user);
            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', compact('user', 'form'));
    }
}
