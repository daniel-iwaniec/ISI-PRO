<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form used to manage student entity.
 */
class StudentType extends AbstractType
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
            ->add('name', 'text', ['label' => 'Imię'])
            ->add('surname', 'text', ['label' => 'Nazwisko'])
            ->add('class', 'entity', [
                'class' => 'AppBundle:SchoolClass',
                'empty_value' => 'wybierz klasę',
                'label' => 'Klasa'
            ]);
    }

    /**
     * Sets default form options.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Student'
        ]);
    }

    /**
     * Returns form name.
     *
     * @return string
     */
    public function getName()
    {
        return 'appbundle_student';
    }
}
