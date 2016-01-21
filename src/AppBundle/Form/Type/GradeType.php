<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Doctrine\ORM\QueryBuilder;

/**
 * Form used to manage grade entity.
 */
class GradeType extends AbstractType
{
    /** @var QueryBuilder */
    private $subjectQuery;

    /**
     * @param QueryBuilder $subjectQuery
     */
    public function __construct(QueryBuilder $subjectQuery)
    {
        $this->subjectQuery = $subjectQuery;
    }

    /**
     * Builds form.
     *
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('grade', 'text', ['label' => 'Ocena'])
            ->add('subject', 'entity', [
                'class' => 'AppBundle:Subject',
                'empty_value' => 'wybierz przedmiot',
                'label' => 'Przedmiot',
                'query_builder' => $this->subjectQuery
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
            'data_class' => 'AppBundle\Entity\Grade'
        ]);
    }

    /**
     * Returns form name.
     *
     * @return string
     */
    public function getName()
    {
        return 'appbundle_grade';
    }
}
