<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Subject;
use AppBundle\Form\Type\SubjectType;

/**
 * Subject controller.
 */
class SubjectController extends Controller
{
    /**
     * Lists all subject entities.
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $repository = $this->get('app_bundle.repository.subject');
        $paginator = $this->get('knp_paginator');

        $paginationQuery = $repository->getAllQuery();
        $paginationPage = $request->query->get('page', 1);
        $paginationSize = $this->container->getParameter('pagination.size');
        $pagination = $paginator->paginate($paginationQuery, $paginationPage, $paginationSize);

        return $this->render('AppBundle:Subject:index.html.twig', [
            'pagination' => $pagination
        ]);
    }

    /**
     * Finds and displays a subject entity.
     *
     * @param integer $id
     * @return Response
     */
    public function showAction($id)
    {
        $repository = $this->get('app_bundle.repository.subject');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        return $this->render('AppBundle:Subject:show.html.twig', [
            'entity' => $entity
        ]);
    }

    /**
     * Creates a new subject entity.
     *
     * @param Request $request
     * @return RedirectResponse | Response
     */
    public function createAction(Request $request)
    {
        $entity = new Subject();

        $form = $this->createForm(new SubjectType(), $entity, [
            'action' => $this->generateUrl('przedmiot_create'),
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

                $this->addFlash('success', 'Pomyślnie dodano przedmiot.');

                return $this->redirect($this->generateUrl('przedmiot'));
            }
        }

        return $this->render('AppBundle:Subject:create.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Edits an existing subject entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse | Response
     */
    public function editAction(Request $request, $id)
    {
        $repository = $this->get('app_bundle.repository.subject');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new SubjectType(), $entity, [
            'action' => $this->generateUrl('przedmiot_edit', ['id' => $entity->getId()]),
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

                $this->addFlash('success', 'Pomyślnie edytowano przedmiot.');

                return $this->redirect($this->generateUrl('przedmiot_edit', ['id' => $id]));
            }
        }

        return $this->render('AppBundle:Subject:edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Deletes a subject entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $repository = $this->get('app_bundle.repository.subject');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('przedmiot_delete', ['id' => $id]))
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

                $this->addFlash('success', 'Pomyślnie usunięto przedmiot.');

                return $this->redirect($this->generateUrl('przedmiot'));
            }
        }

        return $this->render('AppBundle:Subject:delete.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }
}
