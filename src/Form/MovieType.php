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
                'help' => 'Make sure to add a valid director',
            ])
            ->add('cover', TextType::class, [
                'help' => 'Make sure to add a valid cover',
            ])
            ->add('price', NumberType::class, [
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
                'widget' => 'single_text',
            ])
            ->add('duration', IntegerType::class, [
                'help' => 'Make sure to add a valid duration',
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
