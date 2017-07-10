<?php

namespace AppBundle\Domain\Form;

use AppBundle\Domain\DataTransferObject\UserRegistration;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class RegistrationType
 *
 * @package AppBundle\Domain\Form
 */
class RegistrationType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', EmailType::class)
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'first_options' => [
                    'label' => 'Пароль',
                ],
                'second_options' => [
                    'label' => 'Пароль повторно',
                ],
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'formnovalidate' => 'formnovalidate',
                ],
                'label' => 'Зарегистрироваться',
            ])
        ;
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserRegistration::class,
        ]);
    }
}
