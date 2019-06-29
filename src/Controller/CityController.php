<?php

namespace App\Controller;

use App\Entity\City;
use App\Entity\Site;
use App\Form\CityType;
use App\Form\SiteType;
use App\Repository\CityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;




/**
 * @Route("/city")
 */
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

//    /**
//     * @Route("/montreVilles", name="city_show")
//     */
//    public function printList(Request $rq)
//    {
//        $cityRepo=$this->getDoctrine()->getRepository(City::class);
//        $cities=$cityRepo->findAll();
//
//        return $this->render('city/show.html.twig', [
//            'cities' => $cities,
//        ]);
//    }
    /**
     * @Route("/{id}", name="city_show", methods={"GET"})
     */
    public function show(City $city): Response
    {
        return $this->render('city/show.html.twig', [
            'city' => $city,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="city_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, City $city): Response
    {
        $form = $this->createForm(CityType::class, $city);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('city_index', [
                'id' => $city->getId(),
            ]);
        }

        return $this->render('city/edit.html.twig', [
            'city' => $city,
            'form' => $form->createView(),
        ]);
    }

//    /**
//     * @Route("/{id}/edit", name="city_edit")
//     */
//    public function edit(Request $request, $id, EntityManagerInterface $em)
//    {
//
//        $city = $em->getRepository(City::class)->find($id);
//        $form = $this->createForm(CityType::class, $city);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $em->persist($city);
//            $em->flush();
//            $this->addFlash("success","Votre ville a bien été enregistrée");
//
//            return $this->redirectToRoute('city_show', [
//                'id' => $city->getId()]);
//
//        }
//
//        return $this->render('city/new.html.twig', [
//            'city' => $city,
//            'form' => $form->createView(),
//            ]);
//
//    }

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

    }
// Fonction pour rechercher les villes en fonction des lettres entrées par l'organisateur
        /**
         * @Route("/rechercheVille", name="city_search")
         */
        public function search(string $word, EntityManagerInterface $em){
            $cities=$em->getRepository(City::class)->findAll();

    }


}
