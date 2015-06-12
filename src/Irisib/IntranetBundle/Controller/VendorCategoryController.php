<?php
namespace Irisib\IntranetBundle\Controller;

//use Irisib\IntranetBundle\Form\VendorCategoryType.php;
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
}