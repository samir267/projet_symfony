<?php

namespace App\Controller;
use App\Entity\Fournisseur ;
use App\Entity\Commande ;

use App\Entity\Jouet;
use App\Repository\FournisseurRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Doctrine\ORM\EntityRepository;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class JouetController extends AbstractController
{
    /**
     * @Route("/jouet", name="jouet")
     */
    public function index(): Response
    {
        $jouets= $this->getDoctrine()->getRepository(Jouet::class)->findAll();
    return  $this->render('blog/liste.html.twig',['jouets' => $jouets]);
    }


       /**
     * @Route("/jouet/new", name="new_jouet")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function ajouter_jouet(Request $request){
        $jouet = new Jouet();
        $form = $this->createFormBuilder($jouet)
        ->add('code_jouet', TextType::class,array('attr' => array('class' => 'form-control')))
        ->add('des_jouet', TextType::class,array('attr' => array('class' => 'form-control')))
        ->add('qte_stock_jouet', TextType::class,array('attr' => array('class' => 'form-control')))
        ->add('pu_jouet', TextType::class,array('attr' => array('class' => 'form-control')))
        ->add('code_four_jouet', EntityType::class, [
          'class' => Fournisseur::class,
          'query_builder' => function (EntityRepository $er) {
              return(  $er->createQueryBuilder('u')
  
                  ->orderBy('u.des_four', 'ASC'));
          },
          'choice_label' => 'des_four',
      ])
      ->add('save', SubmitType::class, array(
        'label' => 'Ajouter' ,'attr' => array('class' => 'btn btn-outline-primary')       
      ))->getForm();
        $form->handleRequest($request);
  
        if($form->isSubmitted() && $form->isValid()) {
            $jouet = $form->getData();
  
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($jouet);
            $entityManager->flush();
  
            return $this->redirectToRoute('jouet');
        }
        return $this->render('blog/new.html.twig',['form' => $form->createView()]);
    }
  
  
  
  
  
  /**
       * @Route("/jouet/edit/{id}", name="edit_jouet")
       * Method({"GET", "POST"})
       */
      public function edit(Request $request, $id) {
          $jouet = new Jouet();
          $jouet = $this->getDoctrine()->getRepository(Jouet::class)->find($id);
    
          $form = $this->createFormBuilder($jouet)
          ->add('code_jouet', TextType::class,array('attr' => array('class' => 'form-control')))
          ->add('des_jouet', TextType::class,array('attr' => array('class' => 'form-control')))
          ->add('qte_stock_jouet', TextType::class,array('attr' => array('class' => 'form-control')))
          ->add('pu_jouet', TextType::class,array('attr' => array('class' => 'form-control')))
  
          ->add('save', SubmitType::class, array(
            'label' => 'Modifier' ,'attr' => array('class' => 'btn btn-outline-primary')       
          ))->getForm();
    
          $form->handleRequest($request);
    
          if($form->isSubmitted() && $form->isValid()) {
    
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
    
            return $this->redirectToRoute('jouet');
          }
    
          return $this->render('blog/edit.html.twig', array(
            'form' => $form->createView()
          ));
        }
  
         /**
       * @Route("/jouet/delete/{id}",name="delete_jouet")
       * @Method({"DELETE"})
       */
      public function delete(Request $request, $id) {
          $jouet = $this->getDoctrine()->getRepository(Jouet::class)->find($id);
    
          $entityManager = $this->getDoctrine()->getManager();
          $entityManager->remove($jouet);
          $entityManager->flush();
    
          $response = new Response();
          $response->send();
  
          return $this->redirectToRoute('jouet');
        }
  
      
}
