<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ResetPassType;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, 
          UserAuthenticator $authenticator, \Swift_Mailer $mailer): Response
    {
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            $user->setActivationToken(uniqid());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            // do anything else you need here, like send an email
            $message = (new \Swift_Message('Activation de votre compte'))
            ->setFrom('fruitslegumesguinee@gmail.com')
            ->setTo($user->getEmail())
            ->setBody(
                $this->renderView('emails/activation.html.twig',['token'=> $user->getActivationToken()]),
                'text/html'
            );
            $mailer->send($message);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * Verifier l'existance du User en fonction du token
     * @Route("/activation/{token}", name="registration_activation")
     */
    public function activationToken(UserRepository $userRepo, $token)
    {
        $user = $userRepo->findOneBy(['activationToken'=> $token]);
        if(!$user){
            throw $this->createNotFoundException('Ce token est inconnu !');
        }
        $user->setActivationToken("");
        $manager = $this->getDoctrine()->getManager();
        $manager->flush();
        return $this->redirectToRoute('home_index');
    }

    /**
     * Demande d'email 
     * @Route("/passe-oublie", name="registration_forgotten")
     */
    public function forgottenPass(Request $request, UserRepository $userRepo, TokenGeneratorInterface $tokenGenerator, EntityManagerInterface $manager, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(ResetPassType::class);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $email = $form->get('email')->getData();
            $user = $userRepo->findOneBy(['email'=>$email]);
            if(!$user){
                $this->addFlash('danger', 'Cette adresse email inconnue');
                return $this->redirectToRoute('registration_forgotten');
            }
            //generer token et on try le token en bdd 
            try {
                $token = $tokenGenerator->generateToken();
                $user->setResetToken($token);
                $manager->flush();  
            } catch (\Exception $e) {
                $this->addFlash('danger', $e->getMessage());
                return $this->redirectToRoute('registration_forgotten');
            }
            //generer l'url de l'action qui affiche le form modificateur le mdp afin de l'envoyer dans l'email
            $url = $this->generateUrl('registration_reset', ['token'=>$token], UrlGeneratorInterface::ABSOLUTE_URL);
            //Envoyer message user
            $message = (new \Swift_Message('Mot de passe oublié'))
            ->setFrom('fruitslegumesguinee@gmail.com')
            ->setTo($user->getEmail())
            ->setBody("Bonjour,<br><br>Une demande de réinitialisation de mot de passe a été effectuée pour le site Guinée Fruits&Legumes.com. 
                 Veuillez cliquer sur le lien suivant : <a href=$url> Modifier mot de passe </a>", 
                 'text/html' 
            ) ;
            // On envoie l'e-mail
            $mailer->send($message);

            // On crée le message flash de confirmation
            $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

            // On redirige vers la page de login
            return $this->redirectToRoute('app_login');


        }
        return $this->render('registration/forgotten_pass.html.twig',[
            'form'=>$form->createView()
        ]);
    }
    /**
     * Reset MDP 
     * @Route("/reset/pass/{token}", name="registration_reset")
     */
    public function resetPass(Request $request, UserRepository $userRepo, $token, EntityManagerInterface $manager,UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('post')){
            $user = $userRepo->findOneBy(['reset_token'=>$token]);
            if(!$user){
                $this->addFlash('danger', 'Token Inconnu');
                return $this->redirectToRoute('app_login');
            }
            //vider le token
            $user->setResetToken("");
            $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
            $manager->flush();
            $this->addFlash('message', 'Mot de passe mis à jour');

            // On redirige vers la page de connexion
            return $this->redirectToRoute('app_login');
        }
        return $this->render('registration/reset_pass.html.twig',[
            'token'=>$token
        ]);
    }

     /**
    * @Route("/infos", name="registration_infos")
    */
    public function infos()
    {
        return $this->render('registration/mes_infos.html.twig');
    }

      /**
    * @Route("/edit-info", name="registration_edit_infos")
    */
    public function editInfo()
    {
        return $this->render('registration/edit_infos.html.twig');
    }

      /**
    * @Route("/change-password", name="registration_change_password")
    */
    public function changePassword()
    {
        return $this->render('registration/change_password.html.twig');
    }
}
