<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use Doctrine\ORM\EntityManagerInterface;
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
}