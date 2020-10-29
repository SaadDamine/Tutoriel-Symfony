<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Doctrine\ORM\EntityManagerInterface;
//use Doctrine\ORM\Mapping\Entity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/")
     */
    public function index(PinRepository $repo): Response
    {      
        $pins = $repo->findAll();
        return $this->render('pins/index.html.twig',['pins' => $pins]);
    }

    /**
     * @Route("/pins/create",methods={"GET","POST"})
     */
    public function create(Request $request,EntityManagerInterface $em)
    {
        if($request->isMethod("POST")){
            $data = $request->request->all();

            $pin = new Pin;
            $pin->setTitle($data['title']);
            $pin->setDescription($data['description']);

            $em->persist($pin);
            $em->flush();

            return $this->redirect('/');
        }
        return $this->render('pins/create.html.twig');
    }
}
