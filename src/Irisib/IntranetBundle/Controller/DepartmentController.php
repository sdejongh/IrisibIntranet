<?php

namespace Irisib\IntranetBundle\Controller;

use Irisib\IntranetBundle\Form\DepartmentType;
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

    /**
     * Creates a new Department entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Department();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('department_list', array('id' => $entity->getId())));
        }

        return $this->render('IrisibIntranetBundle:Department:formNewDepartment.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Department entity.
     *
     * @param Department $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Department $entity)
    {
        $form = $this->createForm(new DepartmentType(), $entity, array(
            'action' => $this->generateUrl('department_add'),
            'method' => 'POST',
        ));

        return $form;
    }

    /**
     * Displays a form to create a new Department entity.
     *
     */
    public function newAction()
    {
        $entity = new Department();
        $form   = $this->createCreateForm($entity);

        return $this->render('IrisibIntranetBundle:Department:formNewDepartment.html.twig', array(
            'entity' => $entity,
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