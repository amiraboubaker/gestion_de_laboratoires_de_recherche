<?php

namespace App\Form;

use App\Entity\Publication;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Publication Title',
                'required' => true,
            ])
            ->add('journal', TextType::class, [
                'label' => 'Journal',
                'required' => true,
            ])
            ->add('year', DateType::class, [
                'label' => 'Year',
                'widget' => 'single_text',
                'required' => true,
            ])
            ->add('projects', ChoiceType::class, [
                'label' => 'Related Projects',
                'multiple' => true,
                'expanded' => true,
                'choices' => $options['projects'], // Fetch projects dynamically
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Publication::class,
            'projects' => [], // Provide a source for projects
        ]);
    }
}
