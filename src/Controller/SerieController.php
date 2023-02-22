<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

//attribut de la classe qui permet de mutualiser des info
#[Route('/serie', name: 'serie_')]
class SerieController extends AbstractController
{
    #[Route('/list', name: 'list', methods: 'GET')]
    public function list(SerieRepository $serieRepository): Response
    {
        //TODO Récupérer la liste des séries en BDD
        //$series = $serieRepository->findAll();

        //Selectionne les comedy finies avec un tableau de clause WHERE
        $series = $serieRepository->findBy([],["vote"=>'DESC'],50);
        dump($series);
        return $this->render('serie/list.html.twig', ['series' => $series]);

    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id,SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);
        dump($serie);
        //TODO récupération des infos de serie
        return $this->render( 'serie/show.html.twig',['serie'=>$serie]);

    }

    #[Route('/add', name: 'add')]
    public function add(SerieRepository $serieRepository, EntityManagerInterface $entityManager): Response
    {
        $serie = new Serie();
//Settage des infos de la série
        $serie
            ->setName("le magicien")
            ->setBackdrop("backdrop.png")
            ->setDateCreated(new \DateTime())
            ->setGenres("Comedy")
            ->setFirstAirDate(new \DateTime('20022-02-02'))
            ->setLastAirDate(new \DateTime('-6 month'))
            ->setPopularity(850.52)
            ->setPoster("poster.png")
            ->setTmdbId(123456)
            ->setVote(8.5)
            ->setStatus("Ended");

//Utilisation direct de entity manager
        $entityManager->persist($serie);
        // $entityManager->persist($serie2);
        $entityManager->flush();
        /* dump($serie);
//enregistrement en BDD
        $serieRepository->save($serie, true);

        dump($serie);
        $serie->setName("The last of us");
        $serieRepository->save($serie, true);
        dump($serie);*/

        $serieRepository->remove($serie, true);

        //TODO Créer formulaire d'ajout de serie
        return $this->render('serie/add.html.twig');

    }

}
