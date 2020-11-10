<?php

namespace App\Controller;

use App\Entity\Users;
use App\Entity\Client;
use App\Repository\UsersRepository;
use App\Repository\ClientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class UsersController extends AbstractController
{
    /**
     * @Route("/users/client", name="userslist", methods={"GET"})
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
     * @Route("/users/client/{id}", name="usersbyclient", methods={"GET"})
     * Permet afficher liste user d'un client
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
     * @Route("/client/{id}", name="user", methods={"GET"})
     * Permet afficher détail d'un user lié à un client
    */
    public function showUser(Client $user, SerializerInterface $serializer)
    {
        $resultat = $serializer->serialize(
            $user, 
            'json',
            [
                'groups'=>['detailuser']

            ]);

        return new JsonResponse($resultat, 200, [], true);

    }



    /**
     * @Route("/user/{id}", name="update_user_client", methods={"PUT"})
     * Permet d'apporter des modifications à un client et au client auquel il est rattaché
    */
    public function updateUserAndClient(Users $user, ClientRepository $clientRepo, SerializerInterface $serializer, Request $request, EntityManagerInterface $entity, ValidatorInterface $validator)
    {
        $data=$request->getContent();
        $dataTab=$serializer->decode($data, 'json');
        $client=$clientRepo->find($dataTab['client']['id']);

        $serializer->deserialize($data, Users::class, 'json', ['object_to_populate'=>$user]);

        //gestion des erreurs de validation
        $errors=$validator->validate($user);
        if(count($errors)){

            $errorsJson=$serializer->serialize($errors, 'json');
            return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST,[],true);
        }

        $entity->persist($user);
        
        $entity->flush();


        return new JsonResponse("ok modification", 200, [], true);

    }


    /**
     * @Route("/user/{id}", name="update_user", methods={"PUT"})
     * Permet d'apporter des modifications à un user
    */
    public function updateUser(Users $user, ClientRepository $clientRepo, SerializerInterface $serializer, Request $request, EntityManagerInterface $entity, ValidatorInterface $validator)
    {
        $data=$request->getContent();

        $serializer->deserialize($data, Users::class, 'json', ['object_to_populate'=>$user]);

        //gestion des erreurs de validation
        $errors=$validator->validate($user);
        if(count($errors)){

            $errorsJson=$serializer->serialize($errors, 'json');
            return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST,[],true);
        }

        $entity->persist($user);
        
        $entity->flush();


        return new JsonResponse("ok modification", 200, [], true);

    }


    /**
     * @Route("/user", name="create_user", methods={"POST"})
     * Permet d'ajouter un user rattaché à un client
    */
    public function createUser(ClientRepository $clientRepo, SerializerInterface $serializer, Request $request, EntityManagerInterface $entity, ValidatorInterface $validator)
    {
        $data=$request->getContent();

        $dataTab=$serializer->decode($data, 'json');

        $user = new Users();

        $serializer->deserialize($data, Users::class, 'json', ['object_to_populate'=>$user]);
        
        //gestion des erreurs de validation
        $errors=$validator->validate($user);
        if(count($errors)){

            $errorsJson=$serializer->serialize($errors, 'json');
            return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST,[],true);
        }

        $entity->persist($user);
        
        $entity->flush();


        return new JsonResponse("ok modification", 200, [], true);

    }



    /**
     * @Route("/user/{id}", name="user_delete", methods={"DELETE"})
     * Permet de supprimer un téléphone
    */
    public function delete(Users $user, EntityManagerInterface $entity)
    {   
        //enregistrement des données dans la base de données
        $entity->remove($user);
        $entity->flush();

        //retourne la réponse au format Json
        return new JsonResponse('{"success":"true"}',Response::HTTP_OK,[]);

    }



}
