<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Grade;
use AppBundle\Form\Type\GradeType;

/**
 * Grade controller.
 */
class GradeController extends Controller
{
    /**
     * Lists all grade entities.
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $studentId = $request->get('student_id');

        $repository = $this->get('app_bundle.repository.grade');
        $paginator = $this->get('knp_paginator');

        $paginationQuery = $repository->getAllForStudentQuery($studentId);
        $paginationPage = $request->query->get('page', 1);
        $paginationSize = $this->container->getParameter('pagination.size');
        $pagination = $paginator->paginate($paginationQuery, $paginationPage, $paginationSize);

        $repository = $this->get('app_bundle.repository.student');
        $student = $repository->getById($studentId);

        return $this->render('AppBundle:Grade:index.html.twig', [
            'student' => $student,
            'pagination' => $pagination
        ]);
    }

    /**
     * Creates a new grade entity.
     *
     * @param Request $request
     * @return RedirectResponse | Response
     */
    public function createAction(Request $request)
    {
        $entity = new Grade();

        $studentId = $request->get('student_id');
        $studentRepository = $this->get('app_bundle.repository.student');
        $student = $studentRepository->getById($studentId);
        $classId = $student->getClass()->getId();
        $teacher = $this->get('security.context')->getToken()->getUser()->getActor();
        $teacherId = $teacher->getId();

        $repository = $this->get('app_bundle.repository.subject');
        $query = $repository->getForTeacherAndClassQuery($classId, $teacherId);

        $gradeFormType = new GradeType($query);
        $entity->setTeacher($teacher);
        $entity->setStudent($student);

        $form = $this->createForm($gradeFormType, $entity, [
            'action' => $this->generateUrl('ocena_create', ['student_id' => $studentId]),
            'method' => 'PUT'
        ])->add('submit', 'submit', [
            'label' => 'dodaj',
            'attr' => ['class' => 'btn btn-success pull-left btn-add']
        ]);

        if ($request->isMethod('PUT')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($entity);
                $entityManager->flush();

                $this->addFlash('success', 'Pomyślnie dodano ocenę.');

                return $this->redirect($this->generateUrl('ocena', ['student_id' => $studentId]));
            }
        }

        return $this->render('AppBundle:Grade:create.html.twig', [
            'entity' => $entity,
            'student' => $student,
            'form' => $form->createView()
        ]);
    }

    /**
     * Deletes a grade entity.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function deleteAction(Request $request)
    {
        $repository = $this->get('app_bundle.repository.grade');
        $entity = $repository->getById($request->get('grade_id'));

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('ocena_delete', ['grade_id' => $request->get('grade_id')]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', [
                'label' => 'potwierdź usunięcie',
                'attr' => ['class' => 'btn btn-danger pull-right']
            ])->getForm();

        if ($request->isMethod('DELETE')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($entity);
                $entityManager->flush();

                $this->addFlash('success', 'Pomyślnie usunięto ocenę.');

                return $this->redirect($this->generateUrl('ocena', ['student_id' => $entity->getStudent()->getId()]));
            }
        }

        return $this->render('AppBundle:Grade:delete.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
}
