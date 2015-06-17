<?php
namespace Irisib\IntranetBundle\Controller;

use Irisib\IntranetBundle\Form\VendorCategoryType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Irisib\IntranetBundle\Entity\VendorCategory;

class VendorCategoryController extends Controller
{
    /**
     * Displays list of all vendor categories
     */
    public function listAction()
    {
        $categories = $this->getDoctrine()->getRepository('IrisibIntranetBundle:VendorCategory')->findAll();
        return $this->render('IrisibIntranetBundle:VendorCategory:listVendorCategory.html.twig',array('categories' => $categories));
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
            $entity = $em->getRepository('IrisibIntranetBundle:VendorCategory')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Department entity.');
            }

            $em->remove($entity);
            $em->flush();

        }
        return $this->redirect($this->generateUrl('irisib_vendorcategory_list'));

    }

    public function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('irisib_vendorcategory_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->getForm()
            ;
    }

    public function deleteFormAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('IrisibIntranetBundle:VendorCategory')->find($id);
        $form = $this->createDeleteForm($id);

        return $this->render('IrisibIntranetBundle:VendorCategory:formDeleteVendorCategory.html.twig',
            array(
                'delete_form' => $form->createView(),
                'id' => $id,
                'name' => $entity->getFullname(),

            )
        );
    }

    /****************************
     * VENDOR CATEGORY CREATION *
     ****************************/

    /**
     * Creates a new VendorCategory entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new VendorCategory();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);



        if ($form->isValid()) {

            $lowerFullName = strtolower($entity->getFullname());

            $replaceChars = array(
                'à' => 'a', 'â' => 'a',
                'é' => 'e', 'è' => 'e', 'ê' => 'e', 'ë' => 'e',
                'î' => 'i', 'ï' => 'i',
                'ô' => 'o', 'ö' => 'o',
                'ù' => 'u',
                'ÿ' => 'y',
                '@' => '', '#' => '',
                '"' => '', '\''=> '',
                '(' => '', '!' => '',
                'ç' => 'c',')' => '',
                '-' => '_',' ' => '_',
                '?' => '', ',' => '_',
                ';' => '_','/' => '',
                '+' => '', '=' => '',
                '<' => '', '>' => '',
                '\\' => ''
            );

            $shortname = strtr($lowerFullName,$replaceChars);

            $entity->setShortname($shortname);

            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('irisib_vendorcategory_list'));
        }

        return $this->render('IrisibIntranetBundle:VendorCategory:formNewVendorCategory.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a VendorCategory entity.
     *
     * @param Department $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(VendorCategory $entity)
    {
        $form = $this->createForm(new VendorCategoryType(), $entity, array(
            'action' => $this->generateUrl('irisib_vendorcategory_add'),
            'method' => 'POST',
        ));



        return $form;
    }

    /**
     * Displays a form to create a new VendorCategory entity.
     *
     */
    public function newAction()
    {
        $entity = new VendorCategory();
        $form   = $this->createCreateForm($entity);

        return $this->render('IrisibIntranetBundle:VendorCategory:formNewVendorCategory.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

}