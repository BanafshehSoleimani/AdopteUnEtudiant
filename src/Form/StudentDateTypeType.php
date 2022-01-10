<?php

namespace App\Form;

use App\Entity\Student;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class StudentDateTypeType extends AbstractType
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

           ->add('start_at',DateType::class,[
            'label' => 'Date de debut de stage',
            'format' => 'dd-MM-yyyy',
        
        ])
        ->add('end_at',DateType::class,[
            'label' => 'Date de fin de stage',
            'format' => 'd-MM-yyyy',
      
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