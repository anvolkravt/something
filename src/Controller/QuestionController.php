<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\QuestionType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/admin/create/question", name="create_question")
     * @param Request $request
     * @return Response
     */
    public function addQuestion(Request $request): Response
    {
        $question = new Question();
        $answer1 = new Answer();
        $answer2 = new Answer();
        $answer3 = new Answer();
        $answer4 = new Answer();

        $question->addAnswer($answer1);
        $question->addAnswer($answer2);
        $question->addAnswer($answer3);
        $question->addAnswer($answer4);

        $answer1->setIsCorrect(true);

        $form = $this->createForm(QuestionType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->flush();

            return $this->redirectToRoute('admin_main');
        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
            'addQuestionForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/list/questions", name="question_list")
     * @return Response
     */
    public function showQuestions(): Response
    {
        $questions = $this->getDoctrine()
            ->getRepository(Question::class)
            ->findAll();
        $answers = array_map(
            function(Question $question)
            {
                return $question->getAnswers();
            },
            $questions);

        return $this->render('question/questionList.html.twig', [
            'controller_name' => 'QuestionController',
            'questions' => $questions,
            'answers' => $answers
        ]);
    }
}
