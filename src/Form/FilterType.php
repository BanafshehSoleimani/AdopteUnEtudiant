<?php

use App\Classe\Filter;
use App\Entity\Domain;
use App\Entity\Domaine;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

    class FilterType extends AbstractType
    {

        public function buildForm(FormBuilderInterface $builder, array $options): void
        {
            $builder
            ->add('string', TextType::class,[
                'label' => false,
                'required' => false,
                'attr' =>
                [
                    'placeholder' => 'Votre recherche...',
                    'class' => 'form-control-sm'
                ]
            ])
                ->add('domains', EntityType::class,[
                    'label' => false,
                    //'mapped'=>false,
                    'class' => Domain::class,
                    'multiple' => true,
                    'expanded' => true, // Vue sous forme de checkbox
                    'choice_label' => 'name',
                ])
                ->add('submit', SubmitType::class,[
                    'label' => 'Filtrer',
                    'attr' =>[
                        'class' => 'btn-block btn-info'
                    ]
                ])
            ;
        }



        public function configureOptions(OptionsResolver $resolver): void
        {
            $resolver->setDefaults([
                'data_class' => Filter::class,
                'method' => 'GET', // Permet de copier/coller l'URL à des personnes en gardant le filtre activé
                'crsf_protection' => false // Variable liée à la cybersécurité et la protection des informations à l'envoi du formulaire, on la désactive par manque de temps
            ]);
        }

        public function getBlockPrefix()
        {
            return ''; // Pas besoin du nom de la classe dans l'URL
        }
    }