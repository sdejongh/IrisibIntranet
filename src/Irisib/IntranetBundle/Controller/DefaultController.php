<?php

namespace Irisib\IntranetBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('IrisibIntranetBundle:Default:index.html.twig');
    }
}
