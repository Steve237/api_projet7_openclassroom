<?php

namespace App\Controller;

use App\Entity\Mobiles;
use App\Repository\MobilesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MobileController extends AbstractController
{
    
    /**
     * @Route("/mobiles", name="mobiles", methods={"GET"})
     * Permet afficher liste des téléphones
    */
    public function list(MobilesRepository $mobileRepo, SerializerInterface $serializer)
    {
        $mobiles = $mobileRepo->findAll();
        $resultat = $serializer->serialize($mobiles, 'json');

        return new JsonResponse($resultat, 200, [], true);

    }


    /**
     * @Route("/mobile/{id}", name="mobile_details", methods={"GET"})
     * Permet afficher détail d'un téléphone
    */
    public function show(Mobiles $mobile, SerializerInterface $serializer)
    {
        $this->denyAccessUnlessGranted('ROLE_');
        
        $resultat = $serializer->serialize($mobile, 'json');

        return new JsonResponse($resultat, 200, [], true);

    }


    /**
     * @Route("/mobile", name="mobile_create", methods={"POST"})
     * Permet d'ajouter un téléphone
    */
    public function create(Request $request, SerializerInterface $serializer, EntityManagerInterface $entity, ValidatorInterface $validator)
    {   
        //permet de récupérer le contenu posté
        $data=$request->getContent();

        //transforme les données postées au format json
        $mobile=$serializer->deserialize($data, Mobiles::class,'json');

        //gestion des erreurs de validation
        $errors=$validator->validate($mobile);
        if(count($errors)){

            $errorsJson=$serializer->serialize($errors, 'json');
            return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST,[],true);
        }
        //enregistrement des données dans la base de données
        $entity->persist($mobile);

        $entity->flush();

        //retourne la réponse au format Json
        return new JsonResponse(
            $serializer->serialize($mobile, 'json'), Response::HTTP_CREATED, 
            ["location"=>"/mobile".$mobile->getId()],
            true);

    }


     /**
     * @Route("/mobile/{id}", name="mobile_update", methods={"PUT"})
     * Permet d'apporter des modifications au descriptif d'un phone
    */
    public function edit(Mobiles $mobile, Request $request, SerializerInterface $serializer, EntityManagerInterface $entity, ValidatorInterface $validator)
    {   
        //permet de récupérer le contenu posté
        $data=$request->getContent();


        //transforme les données postées au format json et apporte la modification dans l'entité mobile
        $serializer->deserialize($data, Mobiles::class,'json',['object_to_populate'=>$mobile]);

         //gestion des erreurs de validation
         $errors=$validator->validate($mobile);
         if(count($errors)){
 
             $errorsJson=$serializer->serialize($errors, 'json');
             return new JsonResponse($errorsJson, Response::HTTP_BAD_REQUEST,[],true);
         }

        //enregistrement des données dans la base de données
        $entity->persist($mobile);
        $entity->flush();

        //retourne la réponse au format Json
        return new JsonResponse('{"success":"true"}',Response::HTTP_OK,[],true);

    }

    /**
     * @Route("/mobile/{id}", name="mobile_delete", methods={"DELETE"})
     * Permet de supprimer un téléphone
    */
    public function delete(Mobiles $mobile, EntityManagerInterface $entity)
    {   
        //enregistrement des données dans la base de données
        $entity->remove($mobile);
        $entity->flush();

        //retourne la réponse au format Json
        return new JsonResponse('{"success":"true"}',Response::HTTP_OK,[]);

    }

}
