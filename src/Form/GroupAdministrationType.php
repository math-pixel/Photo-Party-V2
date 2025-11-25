<?php

namespace App\Form;

use App\Entity\Group;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class GroupAdministrationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom du groupe',
                'required' => true,
            ])

            ->add('description', TextareaType::class, [
                'label' => 'Message d\'invitation',
                'required' => false,
            ])

            ->add('image1Name', TextareaType::class, [
                'label' => 'Image name 1',
                'required' => false,
            ])

            ->add('image1File', VichImageType::class, [
                'label' => 'Image Principale',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image actuelle',
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => true,
            ])

            ->add('image2Name', TextareaType::class, [
                'label' => 'Image name 2',
                'required' => false,
            ])

            ->add('image2File', VichImageType::class, [
                'label' => 'Image Secondaire',
                'required' => false,
                'allow_delete' => true,
                'delete_label' => 'Supprimer l\'image actuelle',
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => true,
            ])

            ->add('isExplicit', CheckboxType::class, [
                'label' => 'Contenu explicite',
                'required' => false,
            ])

            ->add('isModerated', CheckboxType::class, [
                'label' => 'Modération active',
                'required' => false,
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
