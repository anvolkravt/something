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
     * @Route("/admin/create/quiz", name="create_quiz")
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
            $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quiz);
            $entityManager->flush();

            return $this->redirectToRoute('admin_main');
        }

        return $this->render('quiz/index.html.twig', [
            'controller_name' => 'QuizController',
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/list/quizzes", name="quiz_list")
     * @return Response
     */
    public function showQuizzes(): Response
    {
        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->findAll();
        $questions = array_map(
            function(Quiz $question)
            {
                return $question->getQuestions();
            },
            $quizzes);

        return $this->render('quiz/quizList.html.twig', [
            'controller_name' => 'QuestionController',
            'quizzes' => $quizzes,
            'questions' => $questions
        ]);
    }
}
