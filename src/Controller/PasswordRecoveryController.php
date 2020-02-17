<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\User;
use App\Form\PasswordRecoveryType;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class PasswordRecoveryController extends AbstractController
{
    /**
     * @Route("/password_recovery", name="app_password_recovery")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function resetPassword(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(PasswordRecoveryType::class);
        $form->handleRequest($request);

        $entityManager = $this->getDoctrine()->getManager();
        $user = $entityManager
            ->getRepository(User::class)
            ->find('username');

        if ($form->isSubmitted() && $form->isValid() && $user) {
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

//            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('password_recovery/index.html.twig', [
            'passwordRecoveryForm' => $form->createView(),
        ]);
    }
}
