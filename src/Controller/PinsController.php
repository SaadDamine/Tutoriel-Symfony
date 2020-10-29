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

        $data = ['title'=>'book title','description'=>'book description'];

        $pin = new Pin;
        $pin->setTitle($data['title']);
        $pin->setDescription($data['description']);

        $form = $this->createFormBuilder($pin)
        ->add('title',null,['attr' =>['autofocus' => true]])
        ->add('description',null,['attr' =>['cols' => 60,'rows' => 10]])
        //->add('submit',SubmitType::class,['label' => 'Create Pin'])
        ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){    
            $em->persist($pin);
            $em->flush();

            return $this->redirectToRoute('app_pins_show',['id' =>$pin->getId()]);
        }

        return $this->render('pins/create.html.twig',['monFormulaire' => $form->createView()]);

    }

    /**
     * @Route("/pins/{id}",methods={"GET"})
     */
    public function show(Pin $pin) : Response
    {
        return $this->render('pins/show.html.twig',['pin' => $pin]);
    }
}
