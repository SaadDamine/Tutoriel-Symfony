<?php

namespace App\Controller;

use App\Entity\Pin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(): Response
    {
        $pin = new Pin;
        $pin->setTitle('Title 1');
        $pin->setDescription('Description 1');

        $em = $this->getDoctrine()->getManager();

        $em->persist($pin);
        $em->flush();
    	//dd($pin);	

        return $this->render('pins/index.html.twig');
    }
}
