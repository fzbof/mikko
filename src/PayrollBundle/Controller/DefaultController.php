<?php

namespace PayrollBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PayrollBundle:Default:index.html.twig');
    }
}
