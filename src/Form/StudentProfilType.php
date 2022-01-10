<?php

namespace App\Form;

use App\Entity\Domain;
use App\Entity\Student;
use App\Entity\SearchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StudentProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
           // ->add('email')
           // ->add('roles')
           // ->add('password')
           // ->add('firstname')
           // ->add('lastname')
           // ->add('age')
           // ->add('city')
           // ->add('startAt')
            //->add('endAt')
          
            //->add('domain')
           // ->add('searchtype')
           ->add('photo', FileType::class, [
               'label' => 'Photo de profil',
              'mapped' => false,
              'multiple' => false,
               'required' => false,
           ])

            ->add('firstname', TextType::class, [
                'label' => 'label.firstname',
             
            ])
            ->add('lastname', TextType::class, [
                'label' => 'label.lastname',
            ])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'disabled' => true,
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Votre age',
            ])
      
            ->add('city', TextType::class, [
                'label' => 'Votre adresse',
            ])

            ->add('description', TextareaType::class, [
                'label' => 'label.description',
              
            ])
            ->add('domain', EntityType::class,[
                'label' => 'Domaine',
                'required' => false,
                'class' => Domain::class,
                'multiple' => false,
                'expanded' => false,
            ])
            ->add('searchType', EntityType::class,[
                'label' => 'Type de recherche',
                'required' => false,
                'class' => SearchType::class,
                'multiple' => false,
                'expanded' => true, // Vue sous forme de checkbox

            ])


            ->add('submit', SubmitType::class,[
                'label' => "Modifier",
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}