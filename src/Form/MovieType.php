<?php

namespace App\Form;

use App\Entity\Movie;
use DateTime;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TimeType ;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MovieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'label'  => 'Title:',
                'help' => 'Make sure to add a valid title',
            ])
            ->add('duration', TimeType::class, [
                'label'  => 'Director:',
                'help' => 'Make sure to add a valid duration',
            ])
            ->add('director', TextType::class, [
                'label'  => 'Director:',
                'help' => 'Make sure to add a valid director',
            ])
            ->add('cover', TextType::class, [
                'label'  => 'Cover:',
                'help' => 'Make sure to add a valid cover',
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
