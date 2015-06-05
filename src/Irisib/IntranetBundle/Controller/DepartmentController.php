<?php

namespace Irisib\IntranetBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Irisib\IntranetBundle\Entity\Department;

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

    /***********************
     * DEPARTMENT CREATION *
     ***********************/

    public function createAction(Request $request)
    {
        $department = new Department();
        $form = $this->createNewForm($department);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();

            return $this->redirect($this->generateUrl('department_list'));
        }

        return $this->render('IrisibIntranetBundle:Department:formNewDepartment.html.twig', array(
            'department' => $department,
            'form'   => $form->createView(),
        ));
    }

    private function createNewForm(Department $department)
    {
        $form = $this->createForm(new Department(), $department, array(
            'action' => $this->generateUrl('department_create'),
            'method' => 'POST',
        ));

        return $form;
    }


    public function newAction()
    {
        $department = new Department();
        $form   = $this->createNewForm($department);

        return $this->render('IrisibIntranetBundle:Department:formNewDepartment.html.twig', array(
            'entity' => $department,
            'form'   => $form->createView(),
        ));
    }



    /********************
     * DELETE FUNCTIONS *
     ********************/
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('IrisibIntranetBundle:Department')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Department entity.');
            }

            $em->remove($entity);
            $em->flush();

        }
        return $this->redirect($this->generateUrl('department_list'));

    }

    public function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('department_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function deleteFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $department = $em->getRepository('IrisibIntranetBundle:Department')->find($id);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('IrisibIntranetBundle:Department:formDeleteDepartment.html.twig',
            array(
                'delete_form' => $deleteForm->createView(),
                'id' => $id,
                'name' => $department->getFullname(),

            )
        );
    }

}