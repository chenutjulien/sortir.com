<?php

namespace App\Controller;

use App\Entity\Spot;
use App\Form\SpotType;
use App\Repository\SpotRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/spot")
 */
class SpotController extends Controller
{
    /**
     * @Route("/", name="spot_index", methods={"GET"})
     */
    public function index(EntityManagerInterface $em, SpotRepository $spotRepository): Response
    {
        $user = $this->getUser();
        return $this->render('spot/index.html.twig', [
            'spots' => $spotRepository->findAll(),
            'user'=>$user
        ]);
    }

    /**
     * @Route("/new", name="spot_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $spot = new Spot();
        $form = $this->createForm(SpotType::class, $spot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($spot);
            $entityManager->flush();

            return $this->redirectToRoute('spot_index');
        }

        return $this->render('spot/new.html.twig', [
            'spot' => $spot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spot_show", methods={"GET"})
     */
    public function show(Spot $spot): Response
    {
        return $this->render('spot/show.html.twig', [
            'spot' => $spot,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="spot_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Spot $spot): Response
    {
        $form = $this->createForm(SpotType::class, $spot);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('spot_index', [
                'id' => $spot->getId(),
            ]);
        }

        return $this->render('spot/edit.html.twig', [
            'spot' => $spot,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="spot_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Spot $spot): Response
    {
        if ($this->isCsrfTokenValid('delete'.$spot->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($spot);
            $entityManager->flush();
        }

        return $this->redirectToRoute('spot_index');
    }
}
