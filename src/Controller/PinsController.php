<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Repository\PinRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PinsController extends AbstractController
{
    /**
     * @Route("/",methods={"GET"})
     */
    public function index(PinRepository $repo): Response
    {      
        $pins = $repo->findAll();
        return $this->render('pins/index.html.twig',['pins' => $pins]);
    }

    /**
     * @Route("/pins/create",methods={"GET","POST"})
     */
    public function create(Request $request,EntityManagerInterface $em) : Response
    {
        $form = $this->createFormBuilder()
        ->add('title',TextType::class)
        ->add('description',TextareaType::class)
        ->add('submit',SubmitType::class,['label' => 'Create Pin'])
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $data = $form->getdata();

            $pin = new Pin;
            $pin->setTitle($data['title']);
            $pin->setDescription($data['description']);    
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_pins_index');
        }

        return $this->render('pins/create.html.twig',['monFormulaire' => $form->createView()]);

    }
}
