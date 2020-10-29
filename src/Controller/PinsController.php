<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(PinRepository $repo): Response
    {
        //EntityManagerInterface $em
        /*$pin = new Pin;
        $pin->setTitle('Title 3');
        $pin->setDescription('Description 3');

        $em->persist($pin);
        $em->flush();

        //dd($pin);	*/
        
        //$repo = $em->getRepository(Pin::class);
        $pins = $repo->findAll();

        return $this->render('pins/index.html.twig',['pins' => $pins]);
    }
}
