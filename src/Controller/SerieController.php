<?php

namespace App\Controller;

use App\Entity\Serie;
use App\Form\SerieType;
use App\Repository\SerieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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



        //méthode magique qui est créée dynamiquement en fonction des attributs de l'entité assoccié
        //$series = $serieRepository->findByStatus("ended");
        //dump($series);
        //return $this->render('serie/list.html.twig', ['series' => $series],);

        //Selectionne les comedy finies avec un tableau de clause WHERE
        //$series = $serieRepository->findBy([],["vote"=>'DESC'],50);

        $series = $serieRepository->findBestSeries();
        dump($series);
        return $this->render('serie/list.html.twig', ['series' => $series]);


    }

    #[Route('/{id}', name: 'show', requirements: ['id' => '\d+'])]
    public function show(int $id,SerieRepository $serieRepository): Response
    {
        $serie = $serieRepository->find($id);
//lance erreur 404 si serie n'existe pas
        if(!$serie){
            throw $this->createNotFoundException("Oops ! Serie not found !");
        }

        //TODO récupération des infos de serie
        return $this->render( 'serie/show.html.twig',['serie'=>$serie]);

    }

    #[Route('/add', name: 'add')]
    public function add(SerieRepository $serieRepository, Request $request): Response
    {
        $serie = new Serie();
        //Création d'une instance de form lié à une instance de série
        $serieForm = $this->createForm(SerieType::class,$serie);
        //méthode qui extrait les éléments du formulaire de la requete et les met dans la variable serie
        //il fournit l'objet hydraté
        $serieForm->handleRequest($request);



        if($serieForm->isSubmitted()){
            //set manuellement la date du jour
           // $serie->setDateCreated(new \DateTime());

            //rentre en bdd la nouvelle serie
            $serieRepository->save($serie, true);

            //affichage message qui se supprime automatiquement
            $this->addFlash('success',"Serie added !");

            //redirige vers la page de détail de la serie
            return $this->redirectToRoute('serie_show',['id'=>$serie->getId()]);
        }



        dump($serie);

        //TODO Créer formulaire d'ajout de serie
        return $this->render('serie/add.html.twig',
            ['serieForm'=>$serieForm->createView()]);

    }

}
/*Settage des infos de la série
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
         dump($serie);
//enregistrement en BDD
        $serieRepository->save($serie, true);

        dump($serie);
        $serie->setName("The last of us");
        $serieRepository->save($serie, true);
        dump($serie);

        $serieRepository->remove($serie, true);*/