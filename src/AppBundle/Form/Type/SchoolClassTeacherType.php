<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Form used to manage relation between school's class and teacher.
 */
class SchoolClassTeacherType extends AbstractType
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
            ->add('teacher', 'entity', [
                'class' => 'AppBundle:Teacher',
                'empty_value' => 'wybierz nauczyciela',
                'label' => 'Nauczyciel'
            ])->add('subject', 'entity', [
                'class' => 'AppBundle:Subject',
                'empty_value' => 'wybierz przedmiot',
                'label' => 'Przedmiot'
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
            'data_class' => 'AppBundle\Entity\SchoolClassTeacher'
        ]);
    }

    /**
     * Returns form name.
     *
     * @return string
     */
    public function getName()
    {
        return 'appbundle_school_class_teacher';
    }
}
