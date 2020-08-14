<?php
namespace App\EventListener;

use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RequestListener
{
    private $router;
    private $session;
    private   $securityContext;
    public function __construct(UrlGeneratorInterface $router, SessionInterface $session, ContainerInterface $container, TokenStorageInterface $token)
    {
        $this->router = $router;
        $this->session = $session;
        $this->securityContext = $container;
        $this->token = $token;
    }
    public function onKernelRequest(RequestEvent $event)
    {
        $route = $event->getRequest()->attributes->get('_route');
        if ($route == 'panier_livraison'){
            $panier = $this->session->get('panier', []);
            if(empty($panier)){
               $event->setResponse(new RedirectResponse($this->router->generate('panier_index')));
            }
        //Recuprer l'user actuellement connecté
           if(!is_object($this->token->getToken()->getUser())){
            $event->setResponse(new RedirectResponse($this->router->generate('app_login')));          
           }
        }
    }
}