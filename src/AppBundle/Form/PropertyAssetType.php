<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PropertyAssetType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('coverImage', 'text')
            ->add(
                'images',
                'collection',
                array(
                    'allow_extra_fields' => true
                )
            )
        ;

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class'            => 'AppBundle\\Document\\PropertyAsset',
            'allow_extra_fields'    => true
        ));
    }

    public function getName()
    {
        return 'location';
    }

}
