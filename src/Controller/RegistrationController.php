<?php

namespace App\Controller;

use App\Entity\ResetPasswordRequest;
use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\ResetPasswordRequestRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Contracts\Translation\TranslatorInterface;


class RegistrationController extends AbstractController
{
    function Genere_Password($size)
    {
        // Initialisation des caractères utilisables
        $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
        $password='';
        for($i=0;$i<$size;$i++)
        {
            $password .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
        }

        return $password;
    }

    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, SluggerInterface $slugger, ResetPasswordController $resetPasswordController, MailerInterface $mi, TranslatorInterface $tr): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);
        $user->setActiv(true);
        $user->setAdministrator(false);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $password=$this->Genere_Password(10);
            $user->setPassword($password);

            $photo = $form->get('photo')->getData();

            if ($photo) {
                $originalFilename = pathinfo($photo->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$photo->guessExtension();

                try {
                    $photo->move(
                        $this->getParameter('user_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                }
                $user->setImage($newFilename);
            }
            $entityManager->persist($user);
            $entityManager->flush();
            $emailUser=$user->getEmail();
            $mailer=$mi;
            $translator=$tr;
            $resetPasswordController->processSendingPasswordResetEmail($emailUser, $mailer, $translator)->send();
            // do anything else you need here, like send an email

            return $this->redirectToRoute('main_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
