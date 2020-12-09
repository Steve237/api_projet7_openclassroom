<?php 

namespace App\Services;

use App\Entity\Users;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\ViewEvent;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class ClientSubscriber implements EventSubscriberInterface {

    private $token;
    public function __construct(TokenStorageInterface $token)
    {
        $this->token=$token;
    }
    public static function getSubscribedEvents()
    {
        return [

            KernelEvents::VIEW => ['getAuthenticatedUser', EventPriorities::PRE_WRITE]


        ];
        
    }

    public function getAuthenticatedUser(ViewEvent $event) {

        $entity = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        $client = $this->token->getToken()->getUser();

        if($entity instanceof Users && $method == Request::METHOD_POST) {

            $entity->setClient($client);

        }

        return;

    }

}