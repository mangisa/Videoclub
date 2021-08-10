<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name:',
                'required' => true,
                'empty_data' => '',
            ])
            ->add('surname', TextType::class, [
                'label' => 'Surname:',
                'required' => true,
                'empty_data' => '',
            ])
            ->add('birthdate', DateType::class, [
                'label' => 'Birth date:',
                'widget' => 'single_text',
                'required' => true,
                'empty_data' => null,
                'attr' => [
                    'class' => 'js-datepicker'
                ],
            ])
            ->add('nie', TextType::class, [
                'label'  => 'NIE:',
                'required' => false,
            ])
            ->add('address', TextType::class, [
                'label'  => 'Address:',
                'required' => false,
            ])
            ->add('postalcode', IntegerType::class, [
                'label'  => 'Postal code:',
                'required' => false,
            ])
            ->add('town', TextType::class, [
                'label'  => 'Town:',
                'required' => false,
            ])
            ->add('city', TextType::class, [
                'label'  => 'City:',
                'required' => false,
            ])
            ->add('province', TextType::class, [
                'label'  => 'Province:',
                'required' => false,
            ])
            ->add('country', TextType::class, [
                'label'  => 'Country:',
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
