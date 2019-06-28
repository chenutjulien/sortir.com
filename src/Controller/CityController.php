<?php

namespace App\Controller;

use App\Entity\City;
use App\Form\City1Type;
use App\Form\CityType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class CityController extends Controller
{
    /**
     * @Route("/", name="city_index", methods={"GET"})
     */
    public function index(CityRepository $cityRepository): Response
    {
        return $this->render('city/index.html.twig', [
            'cities' => $cityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nouvelleVille", name="city_create")
     */
    public function create(Request $request, EntityManagerInterface $em)
    {
        $city = new City();
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($city);
            $em->flush();
            $this->addFlash("success","Votre ville a bien été enregistrée");
            return $this->redirectToRoute('city_show');
        }

        return $this->render('city/new.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/montreVilles", name="city_show")
     */
    public function printList(Request $rq)
    {
        $cityRepo=$this->getDoctrine()->getRepository(City::class);
        $cities=$cityRepo->findAll();

        return $this->render('city/show.html.twig', [
            'cities' => $cities,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="city_edit")
     */
    public function edit(Request $request, $id, EntityManagerInterface $em)
    {

        $city = $em->getRepository(City::class)->find($id);
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($city);
            $em->flush();
            $this->addFlash("success","Votre ville a bien été enregistrée");

            return $this->redirectToRoute('city_show', [
                'id' => $city->getId()]);

        }

        return $this->render('city/new.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
            ]);

    }

    /**
     * @Route("/{id}", name="city_delete")
     */
    public function delete(Request $request, $id, EntityManagerInterface $em)
    {
        $city=$em->getRepository(City::class)->find($id);
if($city==null){
    throw $this-> createNotFoundException("Ville inconnue");
}

            $em->remove($city);
            $em->flush();
            $this->addFlash("success","Votre ville a bien été supprimée");

        return $this->redirectToRoute('city_show');



//        public function delete($id, EntityManagerInterface $em, Request $rq){
//        $trip=$em->getRepository(Trip::class)->find($id);
//        if($trip==null){
//            throw $this->createNotFoundException("Cette sortie n'existe pas!");
//        }
//        if ($this->isCsrfTokenValid('delete'.$trip->getId(), $rq->request->get('_token'))){
//            $em->remove($trip);
//            $em->flush();
//            $this->addFlash("success","Sortie annulée");
//        }
//        return $this->redirectToRoute("trip_liste");
//    }



    }
}
