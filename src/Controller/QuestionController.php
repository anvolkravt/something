<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Answer;
use App\Entity\Question;
use App\Form\QuestionCreationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuestionController extends AbstractController
{
    /**
     * @Route("/admin/add_question", name="add_question")
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
        $answer2->setIsCorrect(false);
        $answer3->setIsCorrect(false);
        $answer4->setIsCorrect(false);

        $answer1->setQuestion($question);
        $answer2->setQuestion($question);
        $answer3->setQuestion($question);
        $answer4->setQuestion($question);

        $form = $this->createForm(QuestionCreationType::class, $question);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // ... maybe do some form processing, like saving the Task and Tag objects
            $form->getData();
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($question);
            $entityManager->persist($answer1);
            $entityManager->persist($answer2);
            $entityManager->persist($answer3);
            $entityManager->persist($answer4);
            $entityManager->flush();
        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
            'addQuestionForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/show_questions", name="show_questions")
     */
    public function showQuestions()
    {
//        $entityManager = $this->getDoctrine()->getManager();
//        $questions = $this->getDoctrine()
//            ->getRepository(Question::class)
//            ->findAll();
        $question = $this->getDoctrine()
            ->getRepository(Question::class)
            ->find(1);
        $answers = $question->getAnswers();

        return $this->render('question/questionList.html.twig', [
            'controller_name' => 'QuestionController',
            'question' => $question,
            'answers' => $answers
        ]);
    }
}
