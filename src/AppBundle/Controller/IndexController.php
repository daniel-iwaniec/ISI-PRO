<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Index controller for basic actions.
 */
class IndexController extends Controller
{
    /**
     * Generates homepage.
     *
     * @Route("/", name="index")
     * @Method({"GET"})
     * @param Request $request
     * @return RedirectResponse | Response
     */
    public function indexAction(Request $request)
    {
        /** @noinspection YamlDeprecatedClasses */
        $user = $this->get('security.context')->getToken()->getUser();
        $roles = $user->getRoles();
        reset($roles);
        $role = current($roles);

        if ($role == 'ROLE_TEACHER') {
            return $this->redirectToRoute('klasa');
        } elseif ($role == 'ROLE_STUDENT') {
            return $this->redirectToRoute('ocena', ['student_id' => $user->getActor()->getId()]);
        }

        $repository = $this->get('app_bundle.repository.school_class');
        $paginator = $this->get('knp_paginator');

        $paginationQuery = $repository->getAllQuery();
        $paginationPage = $request->query->get('page', 1);
        $paginationSize = $this->container->getParameter('pagination.size');
        $pagination = $paginator->paginate($paginationQuery, $paginationPage, $paginationSize);

        $gradeRepository = $this->get('app_bundle.repository.grade');
        $grades = [];
        for ($i = 1;
             $i <= 6;
             $i++) {
            $grades[$i] = $gradeRepository->countGradesByGrade($i);
        }

        $attendanceRepository = $this->get('app_bundle.repository.attendance');
        $attendances = [];
        $attendances[0] = $attendanceRepository->countAttendanceByPresence(true);
        $attendances[1] = $attendanceRepository->countAttendanceByPresence(false);

        $studentsByClass = $repository->countStudentsByClass();

        return $this->render('AppBundle:Index:index.html.twig', [
            'repository' => $repository,
            'grades' => $grades,
            'attendances' => $attendances,
            'studentsByClass' => $studentsByClass,
            'pagination' => $pagination
        ]);
    }
}
