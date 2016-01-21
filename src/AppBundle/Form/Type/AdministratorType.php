<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form used to manage administrator entity.
 */
class AdministratorType extends AbstractType
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
            ->add('surname', 'text', ['label' => 'Nazwisko']);
    }

    /**
     * Sets default form options.
     *
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\Administrator'
        ]);
    }

    /**
     * Returns form name.
     *
     * @return string
     */
    public function getName()
    {
        return 'appbundle_administrator';
    }
}
