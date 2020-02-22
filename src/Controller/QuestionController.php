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

        $form = $this->createForm(QuestionCreationType::class, $question);
        $form->handleRequest($request);

//        if ($form->isSubmitted() && $form->isValid()) {
//            // ... maybe do some form processing, like saving the Task and Tag objects
//        }

        return $this->render('question/index.html.twig', [
            'controller_name' => 'QuestionController',
            'addQuestionForm' => $form->createView()
        ]);
    }
}
