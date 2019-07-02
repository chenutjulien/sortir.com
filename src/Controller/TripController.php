<?php

namespace App\Controller;

use App\Entity\Filter;
use App\Entity\Trip;
use App\Entity\User;
use App\Form\FilterType;
use App\Form\TripType;
use App\Repository\TripRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/trip")
 */
class TripController extends Controller
{
    /**
     * @Route("/", name="trip_index", methods={"GET","POST"})
     */
    public function index(PaginatorInterface $paginator, TripRepository $tripRepository, Request $request): Response
    {

        $filter= new Filter();
        $auj=new \DateTime('now');
        $filter->setDebDate($auj);
        $filter->setEndDateTime($auj);
        $form = $this->createForm(FilterType::class, $filter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            return $this->render('trip/index.html.twig', [
                'form' => $form->createView(),
                'trips' => $tripRepository->filterTrip($filter, $this->getUser())
            ]);
        }

        return $this->render('trip/index.html.twig', [
            'form' => $form->createView(),
            'trips' => $tripRepository->filterTrip($filter, $this->getUser())
        ]);


//        return $this->render('trip/index.html.twig', [
//            'trips' => $tripRepository->findTripBySite($this->getUser())
//        ]);


    }

    /**
     * @Route("/new", name="trip_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $trip = new Trip();
        $user=$this->getUser();
        $trip->setOrganiser($user);

        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($trip);
            $entityManager->flush();

            return $this->redirectToRoute('trip_index');
        }

        return $this->render('trip/new.html.twig', [
            'trip' => $trip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trip_show", methods={"GET"})
     */
    public function show(Trip $trip): Response
    {
        $user= new User();
        $user=$this->getUser();
        $registereds= $trip->getRegistereds();
        if($user== null) {
            $this->addFlash("danger", "L'utilisateur est vide");

            return $this ->redirectToRoute('trip_index');
        }else{
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
            'user'=>$user,
            'registereds'=>$registereds]);
        }
    }


    /**
     * @Route("/inscription/{id}", name="trip_register")
     */
    public function register($id, EntityManagerInterface $em, Request  $rq)

    {
        $user=$this->getUser();
        $trip=$em->getRepository(Trip::class)->find($id);
            $trip->addRegistered($user);
            $em->persist($trip);
            $em->flush();
            $this->addFlash("success","Vous êtes bien inscrit(e) à cette sortie");
            return $this->redirectToRoute('trip_show', [
                'id'=>$trip->getId(),
            ]);

    }


    /**
     * @Route("/desistement/{id}", name="trip_pullOut")
     */
    public function pullOut($id, EntityManagerInterface $em, Request $rq){
        $user=$this->getUser();
        $trip=$em->getRepository(Trip::class)->find($id);
        $trip->removeRegistered($user);
        $em->flush();
        $this->addFlash("success","Vous n'êtes plus inscrit(e)s à cette sortie");
        return $this->redirectToRoute('trip_show',[
            'id'=>$trip->getId(),
        ]);
    }



//Mettre le redirectoroute avec un addflash

    /**
     * @Route("/{id}/edit", name="trip_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Trip $trip): Response
    {
        $form = $this->createForm(TripType::class, $trip);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('trip_index', [
                'id' => $trip->getId(),
            ]);
        }

        return $this->render('trip/edit.html.twig', [
            'trip' => $trip,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="trip_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Trip $trip, EntityManagerInterface $em): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trip->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $state=$this->getDoctrine()->getRepository(\App\Entity\State::class)->find(5);
            $trip->setState($state);
            $em->persist($trip);
            $em->flush();
            
        }

        return $this->redirectToRoute('trip_index');
    }
}
