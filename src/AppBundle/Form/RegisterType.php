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
                'username',
                'text'
            )
            ->add(
                'email',
                'email'
            )
            ->add(
                'name',
                'text'
            )
            ->add(
                'phone',
                'text'
            )
            ->add(
                'profilePic',
                'text'
            )
            ->add(
                'type',
                'text'
            )
            ->add('plainPassword', 'repeated', array(
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
        error_log(__METHOD__);
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