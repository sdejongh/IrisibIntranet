<?php

namespace Irisib\IntranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DepartmentController extends Controller
{
    /**
     * Displays list of all departments
     */
    public function listAction()
    {
        $departments = $this->getDoctrine()->getRepository('IrisibIntranetBundle:Department')->findAll();
        return $this->render('IrisibIntranetBundle:Department:listDepartment.html.twig',array('departments' => $departments));
    }
}