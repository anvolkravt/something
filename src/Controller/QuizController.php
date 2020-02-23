<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Quiz;
use App\Form\QuizType;
use DateTime;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuizController extends AbstractController
{
    /**
     * @Route("/admin/create_quiz", name="add_quiz")
     * @param $request
     * @return Response
     * @throws Exception
     */
    public function createQuiz(Request $request): Response
    {
        $quiz = new Quiz();

        $form = $this->createForm(QuizType::class, $quiz);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quiz->setCreationDate(new DateTime());
            $entityManager = $this->getDoctrine()->getManager();
            $questionArray = $form->get('questions')->getData()->toArray();
            for($i = 0; $i < count($questionArray); $i++) {
                $entityManager->persist($questionArray[$i]);
            }

            $form->getData();
            $entityManager->persist($quiz);
            $entityManager->flush();
        }

        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController',
            'form' => $form->createView()
        ]);
    }
}
