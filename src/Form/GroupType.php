<?php

namespace App\Form;

use App\Entity\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Url;

class GroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du groupe',
                'attr' => [
                    'placeholder' => 'Ex: Anniversaire Marie 2024'
                ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Veuillez entrer un nom pour le groupe',
                    ]),
                    new Length([
                        'min' => 3,
                        'minMessage' => 'Le nom doit contenir au moins {{ limit }} caractères',
                        'max' => 255,
                    ]),
                ],
            ])
            ->add('url_image1', UrlType::class, [
                'label' => 'URL Image de couverture',
                'required' => false,
                'attr' => [
                    'placeholder' => 'https://exemple.com/image1.jpg'
                ],
                'constraints' => [
                    new Url([
                        'message' => 'Veuillez entrer une URL valide',
                    ]),
                ],
            ])
            ->add('url_image2', UrlType::class, [
                'label' => 'URL Image secondaire',
                'required' => false,
                'attr' => [
                    'placeholder' => 'https://exemple.com/image2.jpg'
                ],
                'constraints' => [
                    new Url([
                        'message' => 'Veuillez entrer une URL valide',
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Group::class,
        ]);
    }
}
