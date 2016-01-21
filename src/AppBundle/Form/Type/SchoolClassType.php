<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form used to manage school's class entity.
 */
class SchoolClassType extends AbstractType
{
    /**
     * Builds form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('number', 'text', ['label' => 'Rok'])
            ->add('letter', 'text', ['label' => 'Nazwa']);
    }

    /**
     * Sets default form options.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\SchoolClass'
        ]);
    }

    /**
     * Returns form name.
     *
     * @return string
     */
    public function getName()
    {
        return 'appbundle_school_class';
    }
}
