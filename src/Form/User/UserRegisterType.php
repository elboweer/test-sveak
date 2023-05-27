<?php

namespace App\Form\User;

use App\Entity\User\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserRegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'form.user.name'
            ])
            ->add('phone', TextType::class, [
                'label' => 'form.user.phone',
                'attr' => [
                    'pattern' => "2-[0-9]{3}-[0-9]{3}",
                    'class' => 'tel'
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'form.user.email'
            ])
            ->add('education', ChoiceType::class, [
                'label' => 'form.user.education',
                'choices' => array_flip(User::EDUCATION_TYPES),
                'choice_translation_domain' => false
            ])
            ->add('agreedToPersonalDataCollect', CheckboxType::class, [
                'label' => 'form.user.personal_data',
                'required' => false
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'form.user.submit',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'translation_domain' => 'default',
        ]);
    }
}