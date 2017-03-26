<?php

namespace AppBundle\Domain\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class LoginType
 *
 * @package AppBundle\Domain\Form
 */
class LoginType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('_username', TextType::class, [
                'label' => 'Имя пользователя',
                'attr' => [
                    'placeholder' => 'Jane Doe',
                ],
            ])
            ->add('password', PasswordType::class, [
                'label' => 'Пароль',
            ])
            ->add('save', SubmitType::class, [
                'attr' => [
                    'formnovalidate' => 'formnovalidate',
                ],
                'label' => 'Войти',
            ])
        ;
    }
}
