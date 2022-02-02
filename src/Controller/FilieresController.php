<?php

namespace App\Controller;

use App\Entity\Filiere;
use App\Repository\FiliereRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("filieres_", name="filieres_")
 */
class FilieresController extends AbstractController
{

    /**
     * Insertion et affichage des filieres
     * @Route("ajoutEt_liste", name="ajoutEt_liste")
     */
    public function filiere(FiliereRepository $filiereRepository,Request $request, ManagerRegistry $end)
    {
        //on cherche l'utilisateur connecté
        $user= $this->getUser();
        //si l'utilisateur est n'est pas connecté,
        // on le redirige vers la page de connexion
        if (!$user) {
          return $this->redirectToRoute('app_login');
        }

        //sinon on insert les données
        if (!empty($request->request->get('nom_f')) && !empty($request->request->get('abbr_filiere'))) {
            $filiere=new Filiere();
            $filiere->setUser($user);
            $filiere->setNom(ucfirst($request->request->get('nom_f')));
            $filiere->setSigle(strtoupper($request->request->get('abbr_filiere')));
            $filiere->setCreatedAt(new \datetime);
            $manager = $end->getManager();
            $manager->persist($filiere);
            $manager->flush();

            return $this->redirectToRoute('filieres_ajoutEt_liste');
        } 
         
        return $this->render('filieres/filieres.html.twig', [
            'controller_name' => 'FilieresController',
            'filieres'=>$filiereRepository->filieresUser($user),
            'filieresNb'=>$filiereRepository->count([
                'user'=>$user
            ]),
        ]);
    }

    /**
     * Suppression des filieres
     * @Route("suppression/{id}", name="suppression")
     */
    public function suppression_filiere (Filiere $filiere, ManagerRegistry $end)
    {
        //on cherche l'utilisateur connecté
        $user= $this->getUser();
        //si l'utilisateur est n'est pas connecté,
        // on le redirige vers la page de connexion
        if (!$user) {
          return $this->redirectToRoute('app_login');
        }

        //sinon on supprime les données
        $manager = $end->getManager();
        $manager->remove($filiere);
        $manager->flush();

        return $this->redirectToRoute('filieres_ajoutEt_liste');
        
    }

}
