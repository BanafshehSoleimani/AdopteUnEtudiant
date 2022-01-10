<?php

namespace App\Form;

use App\Entity\Company;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class CompanyProfilType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
       

            ->add('logo', FileType::class, [
                'label' => 'votre logo',
                'mapped' => false,
                'multiple' => false,
                'required' => false,
                'attr' =>
                [
                    'class' => 'form-control form-control-lg'
                ]
            ])

            ->add('description', TextareaType::class, [
                'help' => 'help.comment_content',
                'attr' =>
                [
                    'class' => 'form-control form-control-lg'
                ]
            ])

            ->add('name', TextType::class, [
                'label' => 'le nom de l\'entrprise',
                'attr' => [
                    'placeholder' => 'Merci de saisir le nom de l\'entrprise',
                    'class' => 'form-control form-control-lg'
                ]
            ])

            ->add('city', TextType::class, [
                'label' => 'votre ville',
                'attr' => [
                    'placeholder' => 'Merci de saisir votre adresse',
                    'class' => 'form-control form-control-lg'
                ]
            ])

            ->add('email', EmailType::class, [
                'label' => 'Votre email',
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



            ->add('submit', SubmitType::class, [
                'label' => "Modifier",
                'attr' =>
                [
                    'class' => 'form-control form-control-lg submit-subscribe-button'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Company::class,
        ]);
    }
}