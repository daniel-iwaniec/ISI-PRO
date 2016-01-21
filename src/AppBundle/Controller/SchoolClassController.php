<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\SchoolClass;
use AppBundle\Form\Type\SchoolClassType;

/**
 * School's class controller.
 */
class SchoolClassController extends Controller
{
    /**
     * Lists all school's class entities.
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $repository = $this->get('app_bundle.repository.school_class');
        $paginator = $this->get('knp_paginator');

        /** @noinspection YamlDeprecatedClasses */
        $user = $this->get('security.context')->getToken()->getUser();
        $roles = $user->getRoles();
        reset($roles);
        $role = current($roles);

        if ($role == 'ROLE_TEACHER') {
            $paginationQuery = $repository->getAllForTeacherQuery($user->getActor()->getId());
        } else {
            $paginationQuery = $repository->getAllQuery();
        }

        $paginationPage = $request->query->get('page', 1);
        $paginationSize = $this->container->getParameter('pagination.size');
        $pagination = $paginator->paginate($paginationQuery, $paginationPage, $paginationSize);

        return $this->render('AppBundle:SchoolClass:index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Finds and displays a school's class entity.
     *
     * @param integer $id
     * @return Response
     */
    public function showAction($id)
    {
        $repository = $this->get('app_bundle.repository.school_class');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        return $this->render('AppBundle:SchoolClass:show.html.twig', [
            'entity' => $entity
        ]);
    }

    /**
     * Creates a new school's class entity.
     *
     * @param Request $request
     * @return RedirectResponse | Response
     */
    public function createAction(Request $request)
    {
        $entity = new SchoolClass();

        $form = $this->createForm(new SchoolClassType(), $entity, [
            'action' => $this->generateUrl('klasa_create'),
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

                $this->addFlash('success', 'Pomyślnie dodano klasę.');

                return $this->redirect($this->generateUrl('klasa'));
            }
        }

        return $this->render('AppBundle:SchoolClass:create.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Edits an existing school's class entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse | Response
     */
    public function editAction(Request $request, $id)
    {
        $repository = $this->get('app_bundle.repository.school_class');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new SchoolClassType(), $entity, [
            'action' => $this->generateUrl('klasa_edit', ['id' => $entity->getId()]),
            'method' => 'POST',
        ])->add('submit', 'submit', [
            'label' => 'zapisz',
            'attr' => ['class' => 'btn btn-success pull-left']
        ]);

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->flush();

                $this->addFlash('success', 'Pomyślnie edytowano klasę.');

                return $this->redirect($this->generateUrl('klasa_edit', ['id' => $id]));
            }
        }

        return $this->render('AppBundle:SchoolClass:edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Deletes a school's class entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $repository = $this->get('app_bundle.repository.school_class');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('klasa_delete', ['id' => $id]))
            ->setMethod('DELETE')
            ->add('submit', 'submit', [
                'label' => 'potwierdź usunięcie',
                'attr' => ['class' => 'btn btn-danger pull-right']
            ])->getForm();

        if ($request->isMethod('DELETE')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                if (!$entity->getStudents()->isEmpty()) {
                    $this->addFlash('error', 'Nie można usunąć klasy, ponieważ są do niej przypisani uczniowie.');
                } else {
                    $entityManager = $this->getDoctrine()->getManager();
                    $entityManager->remove($entity);
                    $entityManager->flush();

                    $this->addFlash('success', 'Pomyślnie usunięto klasę.');
                }

                return $this->redirect($this->generateUrl('klasa'));
            }
        }

        return $this->render('AppBundle:SchoolClass:delete.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
}
