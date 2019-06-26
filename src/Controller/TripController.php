<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TripController extends Controller
{
    /**
     * @Route("/listTrip", name="trip_trip")
     */
    public function listTrip()
    {
        return $this->render('trip/trip.html.twig');
    }

//Ci-dessous fonction pour afficher le formulaire à remplir pour proposer une sortie
/**
 * @Route("/proposerSortie", name="trip_create")
 */
    public function createTrip(EntityManagerInterface $em, Request $rq){
        $trip= new Trip();
        $tripForm= $this->createForm(TripType::class,$trip);
        $tripForm->handleRequest($rq);


        if($tripForm->isSubmitted()&& $tripForm->isValid()){
            if($trip->getEndDateTime()>$trip->getStartDateTime()){
            $em->persist($trip);
            $em->flush();
            $this->addFlash("success","Votre sortie est bien enregistrée");
            return $this-> redirectToRoute("trip_details",['id'=> $trip->getId()]);
            //Besoin de creer ce chemin (vers le détails de la sortie)+ pas sur que cela fonctionne!!
        }else{
                $this->addFlash("danger","Attention! On ne peut pas mettre une date de fin avant que la sortie n'ait débutée");
                return $this-> redirectToRoute("trip_create");

            }
        }
        return $this->render("trip/create.html.twig", [
            "tripForm"=>$tripForm->createView()
        ]);
}
//Ci-dessous fonction pour afficher une sortie en fonction de son id
    /**
     * @Route("/sortieDetail/{id}", name="trip_details")// Peut-être besoin d'afficher plus
     */

    public function printDetails($id){
    $tripRepo= $this->getDoctrine()->getRepository(Trip::class);
    $trip = $tripRepo->find($id);
    if($trip == null){
        throw $this->createNotFoundException("Cette sortie n'existe plus");
    }
    return $this->render("trip/details.html.twig",[
        "trip"=>$trip]);

    }
//Ci-dessous fonction pour afficher la liste des sorties
    /**
     * @Route("/sortieListe/", name="trip_liste")// Peut-être besoin d'afficher plus
     */

    public function printList(Request $rq, PaginatorInterface $pg){
        $tripRepo= $this->getDoctrine()->getRepository(Trip::class);
        $trips=$tripRepo->findAll();
       // $trips=$pg->paginate($queryTrips, $rq->query->getInt('page'),6);
        return $this->render("trip/liste.html.twig",
            ['trips'=>$trips,
                ]
            );

    }





}