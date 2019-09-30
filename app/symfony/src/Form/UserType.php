<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Name',
                'attr' => [
                    'placeholder' => 'Name',
                ],
            ])
            ->add('year', TextType::class, [
                'label' => 'Year',
                'attr' => [
                    'placeholder' => 'Year',
                ],
            ])
            ->add('city', TextType::class, [
                'label' => 'City',
                'attr' => [
                    'placeholder' => 'City',
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn col green s12',
                ],
            ])
        ;
    }
}
