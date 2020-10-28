<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Client;
use App\Repository\UsersRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    /**
     * @Route("/users/client", name="users", methods={"GET"})
     */
    public function usersList(UsersRepository $repo, SerializerInterface $serializer)
    {
        $users = $repo->findAll();
        $resultat=$serializer->serialize(
            $users,
            'json',
            [
                'groups'=>['listuser']

            ]

        );
        
        return new JsonResponse($resultat,200,[],true);
    }

    /**
     * @Route("/users/client/{id}", name="mobile", methods={"GET"})
     * Permet afficher détail d'un téléphone
    */
    public function show(Client $client, SerializerInterface $serializer)
    {
        $resultat = $serializer->serialize(
            $client, 
            'json',
            [
                'groups'=>['listclient']

            ]);

        return new JsonResponse($resultat, 200, [], true);

    }

    /**
     * @Route("/users/{id}", name="user", methods={"GET"})
     * Permet afficher détail d'un user lié à un client
    */
    public function showUser(Users $user, SerializerInterface $serializer)
    {
        $resultat = $serializer->serialize(
            $user, 
            'json',
            [
                'groups'=>['detailuser']

            ]);

        return new JsonResponse($resultat, 200, [], true);

    }

}
