<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProfileType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'allow_delete' => false,
                'download_uri' => false,
                'image_uri' => false,
                'asset_helper' => true,
                'label' => ' ',
            ])
            ->add('ranks', ChoiceType::class, [
                'choices' => [
                    'Unranked' => 'Unranked',
                    'Iron' => 'Iron',
                    'Bronze' => 'Bronze',
                    'Silver' => 'Silver',
                    'Gold' => 'Gold',
                    'Platinum' => 'Platinum',
                    'Diamond' => 'Diamond',
                    'Master' => 'Master',
                    'Grandmaster' => 'Grandmaster',
                    'Challenger' => 'Challenger',
                ],
                'required' => false,
            ])
            ->add('positions', ChoiceType::class, [
                'choices' => [
                    'Top' => 'Top',
                    'Jungle' => 'Jungle',
                    'Mid' => 'Mid',
                    'ADC' => 'ADC',
                    'Support' => 'Support',
                ],
                'required' => false,
            ])
            ->add('about_me', TextareaType::class, [
                "label" => "À propos de moi",
                'attr' => [
                    'rows' => 4,
                ],
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
