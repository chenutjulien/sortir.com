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
    /**
     * @Route("/register", name="profil_profil")
     */
    public function register(EntityManagerInterface $em, Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = new User();
        $registerForm = $this->createForm(RegisterType::class, $user);
        $registerForm->handleRequest($request);
        if ($registerForm->isSubmitted() && $registerForm->isValid()){
            $hash=$encoder->encodePassword($user, $user->getPassword());
            $user->setPassword($hash);
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Inscription  validée');
            $this->redirectToRoute("user_register");
        }
        return $this->render('user/register.html.twig', [
            'formRegister'=>$registerForm->createView()
        ]);
    }
}
