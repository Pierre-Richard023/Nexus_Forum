<?php

namespace App\Form;

use App\Entity\UserSettings;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserSettingsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('theme', ChoiceType::class, [
                'choices' => [
                    'system' => 'system',
                    'light' => 'light',
                    'dark' => 'dark',
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ->add('topic_answers', CheckboxType::class, [
                'required' => false,
            ])
            ->add('topic_ask', CheckboxType::class, [
                'required' => false,
            ])
            ->add('upvotes', CheckboxType::class, [
                'required' => false,
            ])
            ->add('shares', CheckboxType::class, [
                'required' => false,
            ])
            ->add('moderation', CheckboxType::class, [
                'required' => false,
            ])
            ->add('messages', CheckboxType::class, [
                'required' => false,
            ])
            ->add('comments', CheckboxType::class, [
                'required' => false,
            ])
            ->add('replies', CheckboxType::class, [
                'required' => false,
            ])
            ->add('mentions', CheckboxType::class, [
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => UserSettings::class,
        ]);
    }
}
