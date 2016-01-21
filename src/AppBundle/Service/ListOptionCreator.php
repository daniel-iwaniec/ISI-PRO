<?php

namespace AppBundle\Service;

use Symfony\Component\Form\FormFactory;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Form\Form;

/**
 * Service used to create safe buttons for list options.
 */
class ListOptionCreator
{
    /** @var FormFactory */
    protected $formFactory;

    /**
     * Injects dependencies.
     *
     * @param FormFactory $formFactory
     */
    public function __construct(FormFactory $formFactory)
    {
        $this->formFactory = $formFactory;
    }


    /**
     * Creates toggle access option.
     *
     * @return Form
     */
    public function createToggleAccessOption()
    {
        /** @var FormBuilder $formBuilder */
        $formBuilder = $this->formFactory->createBuilder('form');

        $form = $formBuilder
            ->add('submit', 'submit', [
                'attr' => ['class' => 'btn']
            ])->getForm();

        return $form;
    }
}
