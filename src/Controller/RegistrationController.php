<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Repository\UserRepository;
use App\Security\UserAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

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
            ->setFrom('o.daffe@yahoo.fr')
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
}
