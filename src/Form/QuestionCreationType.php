<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Question;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class QuestionCreationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text',
                TextType::class,
                [
                    'required' => true,
                    'label' => 'Question',
                    'attr' => ['autofocus' => true]
                ]
            )
        ;
        $builder
            ->add('answers',CollectionType::class,[
                'entry_type' => AnswerType::class,
                'entry_options' => ['label' => false],
            ])
        ;

    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Question::class,
        ]);
    }
}
