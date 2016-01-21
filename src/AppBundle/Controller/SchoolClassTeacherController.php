<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\SchoolClassTeacher;
use AppBundle\Form\Type\SchoolClassTeacherType;

/**
 * School's class and teacher relation controller.
 */
class SchoolClassTeacherController extends Controller
{
    /**
     * Assigns teacher to class.
     *
     * @param Request $request
     * @return Response
     */
    public function addAction(Request $request)
    {
        $entity = new SchoolClassTeacher();

        $form = $this->createForm(new SchoolClassTeacherType(), $entity, [
            'action' => $this->generateUrl('class_teacher_add', ['class_id' => $request->get('class_id')]),
            'method' => 'PUT'
        ])->add('submit', 'submit', [
            'label' => 'dodaj',
            'attr' => ['class' => 'btn btn-success pull-left btn-add']
        ]);

        if ($request->isMethod('PUT')) {
            $classRepository = $this->get('app_bundle.repository.school_class');
            $class = $classRepository->getById($request->get('class_id'));
            $entity->setClass($class);
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($entity);
                $entityManager->flush();

                $this->addFlash('success', 'Pomyślnie dodano nauczyciela do klasy.');

                return $this->redirect($this->generateUrl('klasa'));
            }
        }

        return $this->render('AppBundle:SchoolClassTeacher:create.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Removes teacher from class.
     *
     * @param Request $request
     * @return Response
     */
    public function removeAction(Request $request)
    {
        $id = $request->get('class_id');
        $repository = $this->get('app_bundle.repository.school_class');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('class_teacher_remove', ['class_id' => $request->get('class_id')]))
            ->setMethod('DELETE')
            ->add('class_teacher', 'entity', [
                'class' => 'AppBundle:SchoolClassTeacher',
                'empty_value' => 'wybierz nauczyciela',
                'label' => 'Nauczyciel',
                'query_builder' => function ($this) use ($id) {
                    $repository = $this->get('app_bundle.repository.school_class_teacher');
                    return $repository->getBySchoolClassIdQuery($id);
                }
            ])->add('submit', 'submit', [
                'label' => 'potwierdź usunięcie',
                'attr' => ['class' => 'btn btn-danger pull-right']
            ])->getForm();

        if ($request->isMethod('DELETE')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($form->getData()['class_teacher']);
                $entityManager->flush();

                $this->addFlash('success', 'Pomyślnie usunięto nauczyciela z klasy.');

                return $this->redirect($this->generateUrl('klasa'));
            }
        }

        return $this->render('AppBundle:SchoolClassTeacher:delete.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
}
