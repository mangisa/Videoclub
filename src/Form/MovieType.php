<?php

namespace App\Form;

use App\Entity\Movie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotNull;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'empty_data' => '',
                'constraints' => [
                    new NotNull([
                        'message' => 'Title can not be blank',
                    ]),
                    new Length([
                        'max' => 100
                    ]),
                ],
            ])
            ->add('director', TextType::class, [
                'required' => false,
            ])
            ->add('cover', TextType::class, [
                'required' => false,
            ])
            ->add('price', NumberType::class, [
                'required' => true,
                'empty_data' => 0,
                'constraints' => [
                    new NotNull([
                        'message' => 'The price must be greater than 0',
                    ]),
                    new GreaterThan([
                        'value' => 0,
                    ]),
                ],
            ])
            ->add('releaseDate', DateTimeType::class, [
                'required' => false,
                'widget' => 'single_text',
            ])
            ->add('duration', IntegerType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Movie::class,
        ]);
    }
}
