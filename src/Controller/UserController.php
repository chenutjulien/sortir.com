<?php

namespace App\Controller;

use App\Entity\Trip;
use App\Entity\User;
use App\Form\ProfilType;
use App\Form\RegisterType;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class UserController extends Controller
{
    //Fonction qui va servir à enregistrer un utilisateur
    /**
     * @Route("/register", name="user_register")
     */
    public function register(EntityManagerInterface $em, Request $request,UserPasswordEncoderInterface $encoder)
    {
        $user = new User(); //creation d'un nouvel utilisateur
        $registerForm = $this->createForm(RegisterType::class, $user); //Gestion du formulaire et de sa création
        $registerForm->handleRequest($request); //Envoi de la requete
        if ($registerForm->isSubmitted() && $registerForm->isValid()){ //Si formulaire est soumis et valide
            if ( $em->getRepository(User::class)->findOneByUser($user) !== null ) {
                $this->addFlash('danger', 'Pseudo et/ou mail deja utilisé');
                return $this->redirectToRoute("user_register");
            }

            /*
             *    if ($registerForm->isSubmitted() && $registerForm->isValid() && $this->isNotEquals->$user.username)
//                $this->addFlash('danger', 'Pseudo deja utilisé');
             */
            $hash=$encoder->encodePassword($user, $user->getPassword()); //Salage du code
            $user->setPassword($hash); //Salage du code lié à l'utilisateur
            if ( $user->getAdministrator() === true) {
                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']);
            }
            $em->persist($user); //garde en mémoire la variable de l'utilisateur
            $em->flush(); //Enregistre toutes les données depuis la derniere utilisation
            $this->addFlash('success', 'Inscription  validée'); //Message pour annoncer l'enregistrement
            return $this->redirectToRoute("user_register"); //Redirection si succès (ne pas oublier le return)
        }
        return $this->render('user/register.html.twig', [
            'formRegister'=>$registerForm->createView()
        ]);
    }
    //Fonction qui va servir pour se connecter
    /**
     * @Route("/login", name="user_login")
     */
    public function login(AuthenticationUtils $authenticationUtils) {
        $error = $authenticationUtils->getLastAuthenticationError(); //Utilisations des outils d'identification
        $lastUsername = $authenticationUtils->getLastUsername(); //Verification si l'utilisateur est bien identifié
        $user=$this->getUser();

        if ($this->getUser() && $this->getUser()->getActive()===true) {
            return $this->redirectToRoute("trip_index");
        }


        return $this->render("user/login.html.twig", [
            'error' => $error,
            'lastUsername' => $lastUsername,
            'user'=>$user
        ]);
    }
    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout() {
        // On ne fait rien
    }

    /* Fonction qui permettra de modifier le profil de l(utilisateur)
        Similaire à la fonction enregistrer un utilisateur*/
    /**
     * @Route("/modifyProfil/{id}", name="user_profil")
     */

    public function modifyProfil(Request $request, EntityManagerInterface $em, $id, UserPasswordEncoderInterface $encoder)
    {
        $user = $em->getRepository(User::class)->find($id); //Gestion de l'utilisateur inscrit
        if ($user==null) {
            throw  $this->createNotFoundException("Utilisateur inconnu");
        }
        $userForm = $this->createForm(ProfilType::class, $user); //Formulaire associé à l'utilisateur

        $userForm ->handleRequest($request); //Envoi de la requette
        if ($userForm ->isValid() && $userForm->isSubmitted()) //Si formulaire est soumis et valide
        {

            $hash=$encoder->encodePassword($user, $user->getPassword()); //Salage du code
            $user->setPassword($hash); //Salage du code lié à l'utilisateur
            $user=$userForm->getData(); //Envoi des données
            if ( $user->getAdministrator() === true) { // Gestion du role, si coché, l'utilisateur sera admin

                $user->setRoles(['ROLE_ADMIN']);
            } else {
                $user->setRoles(['ROLE_USER']); //sinon, l'utilisateur sera pas admin
            }
            $em->persist($user); //garde en mémoire la variable de l'utilisateur
            try {
            $em->flush(); //Enregistre toutes les données depuis la derniere utilisation
            } catch( DBALException  $e) {
                $this->get('session')->getFlashBag()->add('danger', $e);  //message d'erreur
                return $this->redirect($this->generateUrl('user_profil')); //redirection si echec
            }

            $this->addFlash("success", "Bien joué mon pote ! Profil modifié"); //Message pour annoncer l'enregistrement
            return $this->redirectToRoute("main_home"); //Redirection si succès
        }
        return $this->render("user/profil.html.twig", [
            'editRegister'=>$userForm->createView()
        ]);
    }



    /**
     * @Route("/voirprofil/{id}", name="user_voirprofil")
     */
    public function voirprofil (Request $request, EntityManagerInterface $em, $id) {
        $user=$em->getRepository(User::class)->find($id);
        if ( $user === null ) {
            $this->addFlash("danger", "Participant inexistant");
            return $this->redirectToRoute("trip_index");
        }
        return $this->render("user/voirprofil.html.twig", [
            'user'=> $user
        ]);
    }

    /**
     * @Route("/listeUser", name="user_liste")
     */
    public function printList(EntityManagerInterface $em){
$users=$em->getRepository(User::class)->findAll();
return $this->render("user/liste.html.twig", [
    'users'=>$users
]);

    }
    /**
     * @Route("/Desactiver/{id}", name="user_inactive")
     */
    public function inactivate($id, EntityManagerInterface $em){
        $user=$em->getRepository(User::class)->find($id);
$user->setActive(0);
$em->persist($user);
$em->flush();
return $this->redirectToRoute("user_liste");
    }
    /**
     * @Route("/Activer/{id}", name="user_active")
     */
    public function activate($id, EntityManagerInterface $em){
        $user=$em->getRepository(User::class)->find($id);
        $user->setActive(1);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute("user_liste");
    }

    /**
     * @Route("/Supprimer/{id}", name="user_delete")
     */
    public function delete($id, EntityManagerInterface $em){
        $user=$em->getRepository(User::class)->find($id);
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute("user_liste");
    }

}
