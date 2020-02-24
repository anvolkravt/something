<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\PasswordRecoveryType;
use App\Form\PasswordRecoveryUsernameType;
use App\Form\RegistrationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordRecoveryController extends AbstractController
{
    /**
     * @Route("/password_recovery_user_detection", name="app_password_recovery_username")
     * @param Request $request
     * @return Response
     */
    public function getUsername(Request $request)
    {
        $fakeUser = new User();
        $form = $this->createForm(PasswordRecoveryUsernameType::class, $fakeUser);
        $form->handleRequest($request);
        $username = $form->get('username')->getData();

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager
            ->getRepository(User::class)
            ->find($username);

        if ($form->isSubmitted() && $form->isValid() && $user) {
            return $this->redirect('password_recovery/{username}');
        }

        return $this->render('password_recovery/username.html.twig', [
            'passwordRecoveryUsernameForm' => $form->createView(),
        ]);
    }

    /**
     * @Route("/password_recovery/{username}", name="app_password_recovery")
     * @param EntityManagerInterface $objectManager
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param string $username
     * @return Response
     */
    public function resetPassword(EntityManagerInterface $objectManager, Request $request, UserPasswordEncoderInterface $passwordEncoder, string $username)
    {
        $user = $objectManager
            ->getRepository(User::class)
            ->find($username);

        $form = $this->createForm(PasswordRecoveryType::class, $user);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            $objectManager->persist($user);
            $objectManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('password_recovery/index.html.twig', [
            'passwordRecoveryForm' => $form->createView(),
            'username' => $username
        ]);
    }
}
