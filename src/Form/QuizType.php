<?php

namespace App\Form;

use App\Entity\Question;
use App\Entity\Quiz;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuizType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('isActive')
//            ->add('questions')
            ->add('questions', EntityType::class, [
                'class' => Question::class,
                'choice_name' => 'id',
                'choice_label' => 'text',
                'choice_value' => 'text',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class)
        ;
//        $builder
//            ->add('questions',CollectionType::class,[
//                'label' => false,
//                'entry_type' => QuestionType::class,
//                'entry_options' => ['label' => false]
//            ])
//        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Quiz::class,
        ]);
    }
}
