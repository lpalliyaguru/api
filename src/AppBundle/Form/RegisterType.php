<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Symfony\Component\Validator\Constraints as Assert;

class RegisterType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'email',
                'email',
                array(
                    'constraints' => array(
                        new Assert\NotBlank(),
                        new Assert\Email()
                    )
                )
            )
            ->add(
                'firstName',
                'text',
                array(
                    'constraints' => array(
                        new Assert\NotBlank()
                    )
                )
            )
            ->add(
                'lastName',
                'text',
                array(
                    'constraints' => array(
                        new Assert\NotBlank()
                    )
                )
            )
            ->add(
                'phone',
                'text',
                array(
                    'constraints' => array(
                        new Assert\NotBlank()
                    )
                )
            )
            ->add(
                'profilePic',
                'text'
            )
            ->add(
                'type',
                'text',
                array(
                    'constraints' => array(
                        new Assert\NotBlank()
                    )
                )
            )
            ->add('plainPassword', 'repeated', array(
                    'constraints' => array(
                        new Assert\NotBlank()
                    ),
                    'type' => 'password',
                    'first_options'  => array('label' => 'Password'),
                    'second_options' => array('label' => 'Repeat Password'),
                )
            )
            ->addEventListener(FormEvents::POST_SUBMIT, array($this, 'postSetData'))
        ;
    }

    public function postSetData()
    {

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'         => 'AppBundle\\Document\\User',
                'csrf_protection'    => false,
                'allow_extra_fields' => true,
            )
        );
    }
    public function getName()
    {
        return '';
    }
}