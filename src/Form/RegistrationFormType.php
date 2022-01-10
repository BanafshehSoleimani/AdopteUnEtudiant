<?php

namespace App\Form;

use App\Entity\Domain;
use App\Entity\Domaine;
use App\Entity\Student;
use App\Entity\SearchType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('photo', FileType::class, [
           'label' => 'Photo de profil',
           'mapped' => false,
           'multiple' => false,
           'required' => false,
           'attr' =>
            [
                'class' => 'form-control form-control-lg'
            ]
        ])
            
            ->add('firstname', TextType::class, [
                'label' => 'Votre prénom',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'constraints' => new Length([
                    'min' => 2,
                    'max' => 30
                ]),
                'attr' => [
                    'placeholder' => 'Merci de saisir votre prénom',
                     'class' => 'form-control form-control-lg'
                ]
            ])
            
            ->add('lastname', TextType::class, [
                'label' => 'Votre nom',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'placeholder' => 'Merci de saisir votre nom',
                     'class' => 'form-control form-control-lg'
                ]
            ])
      
            ->add('age', IntegerType::class, [
                'label' => 'Votre age',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'placeholder' => 'Merci de saisir votre age',
                     'class' => 'form-control form-control-lg'
                ]
            ])
      
            ->add('city', TextType::class, [
                'label' => 'Votre adresse',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse',
                     'class' => 'form-control form-control-lg'
                ]
            ])

            ->add('searchType', EntityType::class,[
                'label' => 'Type de recherche',
                'required' => false,
                'class' => SearchType::class,
                'multiple' => false,
                'expanded' => true, // Vue sous forme de checkbox
                'attr' =>
                [
                    'class' => 'form-control form-control-lg'
                ]
            ])

            ->add('start_at',DateType::class,[
                'label' => 'Date de debut de stage',
                'format' => 'dd-MM-yyyy',
                'attr' =>
                [
                    'class' => 'form-control form-control-lg date-form date-form-container'
                ]
            ])
            ->add('end_at',DateType::class,[
                'label' => 'Date de fin de stage',
                'format' => 'dd-MM-yyyy',
                'attr' =>
                [
                    // 'placeholder' => 'jour mois anne',
                    'class' => 'form-control form-control-lg date-form date-form-container'
                ]
            ])

            ->add('domain', EntityType::class,[
                'label' => 'Domaine',
                'label_attr' => [
                    'class' => 'form-label my-1 mr-2'
                    
                ],
                'required' => false,
                'class' => Domain::class,
                'multiple' => false,
                'expanded' => false,
                'attr' =>
                [
                    'class' => 'form-control form-control-lg'
                ]
            ])
            

            ->add('description', TextareaType::class, [
                'help' => 'votre description',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' =>
                [
                    'class' => 'form-control form-control-lg'
                ]
            ])
          
            
                    
            ->add('cv', FileType::class, [
                'label' => 'Ajoutez votre cv',
                'label_attr' => [
                    'class' => 'form-label'
                ],
               'mapped' => false,
               'multiple' => false,
                'required' => false,
                'attr' =>
                [
                    'class' => 'form-control form-control-lg'
                ]
            ])
           
            ->add('motivation', FileType::class, [
                'label' => 'Ajoutez votre lettre de movation',
                'label_attr' => [
                    'class' => 'form-label'
                ],
               'mapped' => false,
               'multiple' => false,
                'required' => false,
                'attr' =>
                [
                    'class' => 'form-control form-control-lg'
                ]
            ])
            
            ->add('email', EmailType::class, [
                'label' => 'Votre email',
                'label_attr' => [
                    'class' => 'form-label'
                ],
                'attr' => [
                    'placeholder' => 'Merci de saisir votre email',
                     'class' => 'form-control form-control-lg'
                ]
            ])
            

            ->add('plainPassword', RepeatedType::class,[
                'mapped' => false,
                'type' => PasswordType::class,
                'invalid_message' => 'Le mot de passe et la confirmation ne sont pas identiques',
                'required' => true,
                'first_options' => [
                    'label' => 'Mot de passe', 
                    'attr' => [
                        'placeholder' => 'Saisissez votre mot de passe',
                         'class' => 'form-control form-control-lg'
                    ]],
                'second_options' => [
                    'label' => 'Confirmez votre mot de passe',
                    'attr' => [
                        'placeholder' => 'Saisissez à nouveau votre mot de passe',
                         'class' => 'form-control form-control-lg'
                    ]]
            ])
            
            

            // ->add('submit', SubmitType::class,[
            //     'label' => "S'inscrire",
            //     'attr' =>
            //     [
            //         'class' => 'form-control form-control-lg'
            //     ]
            // ])
           
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Student::class,
        ]);
    }
}