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

class HomeController extends AbstractController
{
    
   /* private $rep_Four;*/
    /**
     * @Route("/home", name="home")
     */
    public function index(): Response
    {

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }



public function home(){
  /*  $this->addJouet();*/
  /*  $this->remplirfour();*/
  return $this->render('blog/home.html.twig');
/*
   $this->entityManager = $this->getDoctrine()->getManager();
   $this->req2();
   $this->req3();
   $this->req4();
   $this->req5();



   return $this->render('blog/home.html.twig');
   */
  /*
   $jouets= $this->getDoctrine()->getRepository(Jouet::class)->findAll();
    return  $this->render('blog/liste.html.twig',['jouets' => $jouets]);
      */

     

    

}




/*
public function  remplirfour () {
    $entityManager = $this->getDoctrine()->getManager();
    $f = new Fournisseur();
    $f2 = new Fournisseur();
    $f3 = new Fournisseur();
    $f->setCodeFour(1);
    $f->setDesFour("PlayTunisia");
    $f2->setCodeFour(2);
    $f2->setDesFour("ImportSmart");
    $f3->setCodeFour(3);
    $f3->setDesFour("EduGame");
    $entityManager->persist($f);
    $entityManager->flush($f);
    $entityManager->persist($f2);
    $entityManager->flush($f2);
    $entityManager->persist ($f3);
    $entityManager->flush($f3);
}


public function __construct(FournisseurRepository $for_rep)
    {
    $this->rep_Four=$for_rep;
    }
    public function addJouet()
    {
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(2) ;
        $joue->setCodeJouet(1)
            ->setDesJouet("Camionnette Lego")
            ->setQteStockJouet(130)
            ->setPUJouet(20000)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(2) ;
        $joue->setCodeJouet(2)
            ->setDesJouet("Voiture télécommandée")
            ->setQteStockJouet(120)
            ->setPUJouet(45.400)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(3) ;
        $joue->setCodeJouet(3)
            ->setDesJouet("Puzzle La reine des neiges")
            ->setQteStockJouet(300)
            ->setPUJouet(3)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(3) ;
        $joue->setCodeJouet(4)
            ->setDesJouet("Scrabble")
            ->setQteStockJouet(270)
            ->setPUJouet(32.000)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $joue = new Jouet() ;
        $four = $this->rep_Four->find(3) ;
        $joue->setCodeJouet(5)
            ->setDesJouet("Monopoly")
            ->setQteStockJouet(300)
            ->setPUJouet(34.600)
            ->setCodeFourJouet($four) ;
        $this->getDoctrine()->getManager()->persist($joue) ;
        $this->getDoctrine()->getManager()->flush() ;
    }
    */
    public function req2()
    {
        echo "max stock : <br>";
        $jouet = $this->getDoctrine()->getRepository(Jouet::class)->maxStockJouet();
        foreach ($jouet as $value) {
            echo  "jouet : " . $value->getDesJouet() . "<br>";
        }
    }
    public function req3()
    {
        echo "min prix : <br>";
        $jouet = $this->getDoctrine()->getRepository(Jouet::class)->minPrice();
        foreach ($jouet as $value) {
            echo  "jouet : " . $value->getDesJouet() . "<br>";
           
            
        }
    }
    public function req4()
    {
        echo "four plus jouets : <br>";
        $four = $this->getDoctrine()->getRepository(Fournisseur::class)->getMostFourWithGames();
        foreach ($four as  $value) {
            echo "code Fournissuer : " . $value->getCodeFour() . 
             " Fournisseur Description  :" . $value->getDesFour() . "<br>";
        }
    }
    public function req5()
    {
        echo "four aucun jouet : <br>";
        $four = $this->getDoctrine()->getRepository(Fournisseur::class)->getFourWithNoGame();
        foreach ($four as  $value) {
            echo "code Fournissuer : " . $value->getCodeFour() .
              " Fournisseur Description  :" . $value->getDesFour() . "<br>";
        }
    }


    
      
}

