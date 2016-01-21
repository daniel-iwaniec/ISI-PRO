<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Administrator;
use AppBundle\Form\Type\AdministratorType;

/**
 * Administrator controller.
 */
class AdministratorController extends Controller
{
    /**
     * Lists all administrator entities.
     *
     * @param Request $request
     * @return Response
     */
    public function indexAction(Request $request)
    {
        $repository = $this->get('app_bundle.repository.administrator');
        $paginator = $this->get('knp_paginator');

        $paginationQuery = $repository->getAllQuery();
        $paginationPage = $request->query->get('page', 1);
        $paginationSize = $this->container->getParameter('pagination.size');
        $pagination = $paginator->paginate($paginationQuery, $paginationPage, $paginationSize);

        $listOptionCreator = $this->get('app_bundle.service.list_option_creator');

        return $this->render('AppBundle:Administrator:index.html.twig', [
            'listOptionCreator' => $listOptionCreator,
            'pagination' => $pagination
        ]);
    }

    /**
     * Finds and displays a administrator entity.
     *
     * @param integer $id
     * @return Response
     */
    public function showAction($id)
    {
        $repository = $this->get('app_bundle.repository.administrator');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        return $this->render('AppBundle:Administrator:show.html.twig', [
            'entity' => $entity
        ]);
    }

    /**
     * Creates a new administrator entity.
     *
     * @param Request $request
     * @return RedirectResponse | Response
     */
    public function createAction(Request $request)
    {
        $entity = new Administrator();

        $form = $this->createForm(new AdministratorType(), $entity, [
            'action' => $this->generateUrl('administrator_create'),
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

                $this->addFlash('success', 'Pomyślnie dodano administratora.');

                return $this->redirect($this->generateUrl('administrator'));
            }
        }

        return $this->render('AppBundle:Administrator:create.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Edits an existing administrator entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse | Response
     */
    public function editAction(Request $request, $id)
    {
        $repository = $this->get('app_bundle.repository.administrator');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(new AdministratorType(), $entity, [
            'action' => $this->generateUrl('administrator_edit', ['id' => $entity->getId()]),
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

                $this->addFlash('success', 'Pomyślnie edytowano administratora.');

                return $this->redirect($this->generateUrl('administrator_edit', ['id' => $id]));
            }
        }

        return $this->render('AppBundle:Administrator:edit.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Deletes a administrator entity.
     *
     * @param Request $request
     * @param integer $id
     * @return RedirectResponse
     */
    public function deleteAction(Request $request, $id)
    {
        $repository = $this->get('app_bundle.repository.administrator');
        $entity = $repository->getById($id);

        if (!$entity) {
            throw $this->createNotFoundException();
        }

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('administrator_delete', ['id' => $id]))
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

                $this->addFlash('success', 'Pomyślnie usunięto administratora.');

                return $this->redirect($this->generateUrl('administrator'));
            }
        }

        return $this->render('AppBundle:Administrator:delete.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Creates administrator's account.
     *
     * @param Request $request
     * @return Response
     */
    public function createAccountAction(Request $request)
    {
        $entityId = $request->get('id');

        $formFactory = $this->get('fos_user.registration.form.factory');
        $userManager = $this->get('fos_user.user_manager');

        $entityManager = $this->getDoctrine()->getManager();
        $repository = $this->get('app_bundle.repository.administrator');
        $entity = $repository->getById($entityId);

        /** @var \UserBundle\Entity\User $user */
        $user = $userManager->createUser();
        $user->setEnabled(true);
        $user->setEmail($entityId . '@edu.com');
        $user->setRoles(['ROLE_ADMINISTRATOR']);

        $form = $formFactory->createForm();
        $form->setData($user);

        $form->handleRequest($request);
        if ($form->isValid()) {
            $user->setActor($entity);
            $userManager->updateUser($user);

            /** @noinspection PhpParamsInspection */
            $entity->setUser($user);
            $entityManager->persist($entity);
            $entityManager->flush();

            $this->addFlash('success', 'Pomyślnie utworzono konto.');

            return $this->redirect($this->generateUrl('administrator'));
        }

        return $this->render('AppBundle:Administrator:create-account.html.twig', [
            'entity' => $entity,
            'form' => $form->createView()
        ]);
    }

    /**
     * Toggles access to the system.
     *
     * @param Request $request
     * @return RedirectResponse | Response
     */
    public function toggleAccessAction(Request $request)
    {
        try {
            $listOptionCreator = $this->get('app_bundle.service.list_option_creator');
            $form = $listOptionCreator->createToggleAccessOption();

            $form->handleRequest($request);
            if ($form->isValid()) {
                $repository = $this->get('app_bundle.repository.administrator');
                $entity = $repository->getById($request->get('id'));

                if (!$entity) {
                    throw new \Exception();
                }

                $user = $entity->getUser();
                if ($user->isEnabled()) {
                    $user->setEnabled(false);
                    $successMessage = 'Pomyślnie odebrano dostęp.';
                } else {
                    $user->setEnabled(true);
                    $successMessage = 'Pomyślnie nadano dostęp.';
                }

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($user);
                $entityManager->flush();

                if ($request->isXmlHttpRequest()) {
                    return new JsonResponse([
                        'success' => true,
                        'message' => $successMessage
                    ]);
                } else {
                    $this->addFlash('success', $successMessage);
                    return $this->redirect($this->generateUrl('administrator'));
                }
            } else {
                throw new \Exception();
            }
        } catch (\Exception $exception) {
            if ($request->isXmlHttpRequest()) {
                return new JsonResponse([
                    'success' => false,
                    'message' => 'Wystąpił błąd.'
                ]);
            } else {
                $this->addFlash('error', 'Wystąpił błąd.');
                return $this->redirect($this->generateUrl('administrator'));
            }
        }
    }
}
