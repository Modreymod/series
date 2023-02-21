<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
//attribut de la classe qui permet de mutualiser des info
#[Route('/serie', name: 'serie_')]
class SerieController extends AbstractController
{
    #[Route('/list', name: 'list')]
    public function list(): Response
    {
        //TODO Récupérer la liste des séries en BDD
        return $this->render('serie/list.html.twig');

    }
    #[Route('/{id}', name: 'show',requirements: ['id'=> '\d+'])]
    public function show(int $id): Response
    {
        dump($id);
        //TODO récupération des infos de serie
        return $this->render('serie/show.html.twig');

    }
    #[Route('/add', name: 'add')]
    public function add(): Response
    {
        //TODO Créer formulaire d'ajout de serie
        return $this->render('serie/add.html.twig');

    }

}
