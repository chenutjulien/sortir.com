<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Form\TripType;
use App\Repository\TripRepository;
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
     * @Route("/", name="trip_index", methods={"GET"})
     */
    public function index(PaginatorInterface $paginator, TripRepository $tripRepository, Request $request): Response
    {

//        $tripRepo = $this->getDoctrine()->getRepository(Trip::class);
//
//        $queryTrip=$tripRepo->findTripBySite($this->getUser());
//        $numbTrip=$tripRepo->getNumberOfTrips();
//
//        $trip = $paginator->paginate($queryTrip, $request->query->getInt('page'),5);
//        return $this->render('trip/index.html.twig', [
//            'trips' => $trip,
//            'nbreSorties' => $numbTrip
//        ]);


        return $this->render('trip/index.html.twig', [
            'trips' => $tripRepository->findTripBySite($this->getUser())
        ]);


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
        return $this->render('trip/show.html.twig', [
            'trip' => $trip,
        ]);
    }

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
    public function delete(Request $request, Trip $trip): Response
    {
        if ($this->isCsrfTokenValid('delete'.$trip->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($trip);
            $entityManager->flush();
        }

        return $this->redirectToRoute('trip_index');
    }
}
