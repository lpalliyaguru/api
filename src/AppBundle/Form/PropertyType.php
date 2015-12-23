<?php

namespace AppBundle\Form;

use AppBundle\Document\Property;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class PropertyType extends AbstractType
{
    private $cache = array();

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
            ->add(
                'location',
                new LocationType()
            )
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
                'asset',
                new PropertyAssetType()

            )
            ->add(
                'special',
                'collection',
                array(
                    'type'   => 'text'
                )
            )
            ->add(
                'published',
                'checkbox'
            )
            /*->add(
                'preferred',
                'document',
                array(
                    'class'     => 'AppBundle:Preferred'
                )
            )*/
            ->addEventListener(FormEvents::PRE_SUBMIT,  array($this, 'preSubmitData'))
            ->addEventListener(FormEvents::POST_SUBMIT, array($this, 'postSetData'))
        ;
    }

    public function preSubmitData(FormEvent $event)
    {
        $property = $event->getData();
        $this->cache['images'] = $property['asset']['images'];
    }

    public function postSetData(FormEvent $event)
    {
        $property = $event->getData();
        $property->getLocation()->cleanCoords(); //cleaning the coordinates
        $property->getAsset()->setImages($this->cache['images']); //setting missing images. This, we will have to use for other arrays as well

    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'         => 'AppBundle\\Document\\Property',
                'csrf_protection'    => false,
                'allow_extra_fields' => true,
            )
        );
    }

    public function getName()
    {
        return 'property';
    }
}
