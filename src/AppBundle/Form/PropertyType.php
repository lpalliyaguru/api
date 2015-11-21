<?php

namespace AppBundle\Form;

use AppBundle\Document\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PropertyType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add(
                'name',
                'text'
            )
            ->add(
                'address',
                'text'
            )
            ->add(
                'description',
                'text'
            )
            /*->add(
                'location',
                'document',
                array(
                    'class'     => 'AppBundle:Location'
                )
            )*/
            ->add(
                'zip',
                'text'
            )
            ->add(
                'condition',
                'text'
            )
            ->add(
                'type',
                'choice',
                array(
                    'choices' => Property::$types
                )
            )
            ->add(
                'images',
                'collection',
                array(
                    'type'   => 'text'
                )
            )
            ->add(
                'special',
                'collection',
                array(
                    'type'   => 'text'
                )
            )
            /*->add(
                'preferred',
                'document',
                array(
                    'class'     => 'AppBundle:Preferred',
                    'multiple'  => 'true'
                )
            )*/
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class' => 'AppBundle\Document\Property',
                'csrf_protection' => false,
            )
        );
    }

    public function getName()
    {
        return 'property';
    }

}