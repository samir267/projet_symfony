<?php

namespace App\Controller;
use App\Entity\Commande ;
use App\Entity\Client ;
use App\Entity\ LigneCde;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;


use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ComController extends AbstractController
{
    /**
     * @Route("/com", name="com")
     */
    public function index(): Response
    {
        $cmds= $this->getDoctrine()->getRepository(Commande::class)->findAll();
        return  $this->render('cmd/index.html.twig',['cmds' => $cmds]);
    }


     /**
     * @Route("/commande/delete/{id}",name="delete_commande")
     * @Method({"DELETE"})
     */
    public function delete(Request $request, $id) {
        $cmd = $this->getDoctrine()->getRepository(Commande::class)->find($id);
  
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($cmd);
        $entityManager->flush();
  
        $response = new Response();
        $response->send();

        return $this->redirectToRoute('com');
      }


      /**
     * @Route("/commande/new", name="new_commande")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ajouter_commande(Request $request){
        $commande = new Commande();
        $form = $this->createFormBuilder($commande)
        ->add('nul_cde', TextType::class,array('attr' => array('class' => 'form-control')))
        ->add('date_cde', DateType::class)
        ->add('heure_cde', TimeType::class)
        ->add('remise_cde', TextType::class,array('attr' => array('class' => 'form-control')))
        ->add('mnt_cde', TextType::class,array('attr' => array('class' => 'form-control')))

        ->add('code_clt_cde', EntityType::class, [
          'class' => Client::class,
          'query_builder' => function (EntityRepository $er) {
              return(  $er->createQueryBuilder('u')
                  ->orderBy('u.des_clt', 'ASC'));
          },
          'choice_label' => 'des_clt',
          

      ])
      ->add('save', SubmitType::class, array(
        'label' => 'Ajouter' ,'attr' => array('class' => 'btn btn-outline-primary')       
      ))->getForm();
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
            $jouet = $form->getData();
  
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($commande);
            $entityManager->flush();
  
            return $this->redirectToRoute('com');
        }
        return $this->render('cmd/new.html.twig',['form' => $form->createView()]);
    }
  
  /**
     * @Route("/commande/edit/{id}", name="edit_commande")
     * Method({"GET", "POST"})
     */
    public function edit(Request $request, $id) {
        $commande = new Commande();
        $commande = $this->getDoctrine()->getRepository(Commande::class)->find($id);
  
        $form = $this->createFormBuilder($commande)
        ->add('nul_cde', TextType::class,array('attr' => array('class' => 'form-control')))
        ->add('date_cde', DateType::class,array('attr' => array('class' => 'form-control')))
        ->add('heure_cde', TimeType::class,array('attr' => array('class' => 'form-control')))
        ->add('remise_cde', TextType::class,array('attr' => array('class' => 'form-control')))
        ->add('mnt_cde', TextType::class,array('attr' => array('class' => 'form-control')))

        ->add('save', SubmitType::class, array(
          'label' => 'Modifier' ,'attr' => array('class' => 'btn btn-outline-primary')       
        ))->getForm();
  
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
  
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->flush();
  
          return $this->redirectToRoute('com');
        }
  
        return $this->render('blog/edit.html.twig', array(
          'form' => $form->createView()
        ));
      }

  
  

}
