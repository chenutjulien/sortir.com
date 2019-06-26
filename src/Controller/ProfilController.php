<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\User;

class ProfilController extends Controller
{
    /**
     * @Route("/validProfil", name="profil_profil")
     */
    public function validProfil()
    {

        return $this->render('profil/profil.html.twig');
    }

//    /**
//     * @Route("/modifyProfil", name="profil_profil"
//     */
//    public function modifyProfil(Request $request, User $id)
//    {
//
//        $editForm = $this->createForm('AppBundle\Form\UserType', $id);
//        $editForm->handleRequest($request);
//
//        if ($editForm->isSubmitted() && $editForm->isValid()) {
//            $em = $this->getDoctrine()->getManager();
//            $em->persist($id);
//            $em->flush();
//
//            return $this->redirectToRoute('profil_profil');
//        }
//
//        return $this->render('profil/profil.html.twig', array(
//            'username' => $id,
//            'edit_form' => $editForm->createView(),
//
//        ));
//    }
}
