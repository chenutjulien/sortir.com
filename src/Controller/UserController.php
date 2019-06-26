<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegisterType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends Controller
{
    /**
     * @Route("/register", name="user_register")
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

    /**
     * @Route("/login", name="user_login")
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render("user/login.html.twig", [
            'error' => $error,
            'lastUsername' => $lastUsername
        ]);
    }
    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout() {
        // On ne fait rien
    }

}
