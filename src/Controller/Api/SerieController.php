<?php

namespace App\Controller\Api;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

#[Route('/api/serie', name: 'api_serie_')]
class SerieController extends AbstractController
{
    #[Route('', name: 'retrieve_all', methods: "GET")]
    public function retrieveAll(SerieRepository $serieRepository): Response
    {
        //recupere toutes les series
        $series = $serieRepository->findAll();
        //renvoie données fomat json en utilisant groups
        return $this->json($series, 200,[],["groups" => "serie_api"]);
    }

    #[Route('/{id}', name: 'retrieve_one', methods: "GET")]
    public function retrieveOne(int $id, SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);
        return $this->json($serie, 200,[],["groups" => "serie_api"]);
    }

    #[Route('', name: 'add', methods: "POST")]
    //recupere données requete http
    public function add(Request $request, SerializerInterface $serializer): Response
    {

        //recupere info dans getContent()
        $data = $request->getContent();
        //serializer permet de transformer la donnée en JSON en instance de série
        $serie = $serializer->deserialize($data,Serie::class,'json');
        //reste a sauvegarder en BDD
        return $this->json("ok");
    }

    #[Route('/{id}', name: 'remove', methods: "DELETE")]
    public function remove(): Response
    {
        //TODO delete the serie
    }

    #[Route('/{id}', name: 'update', methods: "PUT")]
    public function update(): Response
    {
        //TODO delete the serie
    }
}
