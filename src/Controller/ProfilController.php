<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ProfilController extends Controller
{
    /**
     * @Route("/validProfil", name="profil_profil")
     */
    public function validProfil()
    {

        return $this->render('profil/profil.html.twig');
    }

/* Fonction qui permettra de modifier le profil de l(utilisateur)*/
//    /**
//     * @Route("/modifyProfil", name="profil_profil")
//     * @ParamConverter("user", options={"mapping": {"user_register" : "user"}})
//     * @ParamConverter("modify", options={"mapping": {"user_register" : "id"}})
//     */
//    public function modifyProfil(Request $request, User $id)
//    {
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
//        return $this->render('profil/profil.html.twig', array(
//            'id' => $id,
//            'editForm' => $editForm->createView()
//        ));
//    }
}
