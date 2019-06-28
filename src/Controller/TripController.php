<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\RemembermeToken;
use App\Entity\Trip;
use App\Form\CityType;
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
                $trip->setOrganiser($this->getUser());
            $em->persist($trip);
            $em->flush();
            $this->addFlash("success","Votre sortie est bien enregistrée");
            return $this-> redirectToRoute("trip_details",['id'=> $trip->getId()]);

        }else{
                $this->addFlash("danger","Attention! On ne peut pas mettre une date de fin avant que la sortie n'ait débutée");
                return $this-> redirectToRoute("trip_create");

            }
        }
        return $this->render("trip/create.html.twig", [
            "tripForm"=>$tripForm->createView(),
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

//Ci-dessous fonction pour annuler une sortie
    /**
     * @Route("/annulerSortie/{id}", name="trip_delete")
     */

    public function delete($id, EntityManagerInterface $em, Request $rq){
$trip=$em->getRepository(Trip::class)->find($id);
if($trip==null){
    throw $this->createNotFoundException("Cette sortie n'existe pas!");
}
if ($this->isCsrfTokenValid('delete'.$trip->getId(), $rq->request->get('_token'))){
    $em->remove($trip);
    $em->flush();
    $this->addFlash("success","Sortie annulée");
}
return $this->redirectToRoute("trip_liste");
    }


//Ci-dessous fonction pour modifier une sortie
    /**
     * @Route("/modifierSortie/{id}", name="trip_update")
     */

    public function update($id, EntityManagerInterface $em, Request $rq){
        $trip=$em->getRepository(Trip::class)->find($id);
        if($trip==null){
            throw $this->createNotFoundException("Cette sortie n'existe pas!");
        }
        $tripForm=$this->createForm(TripType::class,$trip);
        $tripForm->handleRequest($rq);
        if($tripForm->isSubmitted() && $tripForm->isValid()){
            $em->persist($trip);
            $em->flush();
            $this->addFlash("success","Vos modifications ont bien été prises en compte");
            return $this->redirectToRoute("trip_details", ['id'=>$trip->getId()]);
        }
        return $this-> render("trip/update.html.twig", ['tripForm'=> $tripForm->createView()]);
    }

}