<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use AppBundle\Entity\Attendance;

/**
 * Attendance controller.
 */
class AttendanceController extends Controller
{
    /**
     * Checks student's attendance.
     *
     * @param Request $request
     * @return RedirectResponse | Response
     */
    public function createAction(Request $request)
    {
        $classRepository = $this->get('app_bundle.repository.school_class');
        $class = $classRepository->getById($request->get('class_id'));

        $students = $class->getStudents();

        $form = $this->createFormBuilder()
            ->setAction($this->generateUrl('obecnosc_create', ['class_id' => $request->get('class_id')]))
            ->setMethod('PUT');

        foreach ($students as $student) {
            $form->add((string)$student->getId(), 'checkbox', [
                'label' => $student,
                'required' => false
            ]);
        }

        $form = $form->add('submit', 'submit', [
            'label' => 'zapisz',
            'attr' => ['class' => 'btn btn-success btn-add']
        ])->getForm();

        if ($request->isMethod('PUT')) {
            $form->handleRequest($request);

            /** @var \Doctrine\ORM\EntityManager $entityManager */
            $entityManager = $this->getDoctrine()->getManager();

            $attendances = $form->getData();
            foreach ($attendances as $studentId => $presence) {
                $entity = new Attendance();
                $entity->setCheckDate(new \DateTime());
                $entity->setPresent($presence);
                /** @noinspection PhpParamsInspection */
                $entity->setStudent($entityManager->getReference('AppBundle:Student', $studentId));

                /** @noinspection YamlDeprecatedClasses */
                $validator = $this->get('validator');
                $errors = $validator->validate($entity);

                if (count($errors) > 0) {
                    foreach ($errors as $error) {
                        /** @var \Symfony\Component\Validator\ConstraintViolation $error */
                        $this->addFlash('error', $error->getMessage());
                        return $this->redirect($this->generateUrl('klasa'));
                    }
                } else {
                    $entityManager->persist($entity);
                }
            }
            $entityManager->flush();

            $this->addFlash('success', 'Pomyślnie sprawdzono obecność.');

            return $this->redirect($this->generateUrl('klasa'));
        }

        return $this->render('AppBundle:Attendance:create.html.twig', [
            'class' => $class,
            'form' => $form->createView(),
            'students' => $students
        ]);
    }
}
