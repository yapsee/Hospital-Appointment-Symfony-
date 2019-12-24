<?php

namespace App\Controller;

use App\Repository\MedecinRepository;
use App\Form\MedecinType;
use App\Entity\Medecin;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MedecinController extends AbstractController
{
    /**
     * @Route("/medecins", name="listmedecin")
     */
    public function listMedecin(MedecinRepository $repos)

    {
    
        $medecins = $repos->findAll();
        return $this->render('medecin/index.html.twig', [
            'medecins' => $medecins,
        ]);
    }
    /**
     * @Route("/medecin/add", name="addmedecin")
     */
    public function addMedecin(Request $request )
    {
        $idmatricule=$this->getLastMedecin() +1;
        
        $medecin= new Medecin();
        // ...

        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $twofirstletters=\strtoupper(\substr($medecin->getService()->getLibelle(),0,2));
            $longid=strlen((string)$idmatricule);
            $matricule = \str_pad("M".$twofirstletters,8 - $longid,"0").$idmatricule;
            $medecin->setMatricule($matricule);

            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medecin);
            $entityManager->flush();
            $this->addFlash('success','Medecin cree avec succes');

            return $this->redirectToRoute('listmedecin');
        }

        return $this->render('medecin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/medecin/edit/{id}", name="editmedecin")
     */
    public function editMedecin($id, Request $request, MedecinRepository $repos)
    {
        $medecin = $repos->find($id);
        // ...

        $form = $this->createForm(MedecinType::class, $medecin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            // ... perform some action, such as saving the task to the database
            // for example, if Task is a Doctrine entity, save it!
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($medecin);
            $entityManager->flush();

            return $this->redirectToRoute('listmedecin');
        }

        return $this->render('medecin/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/medecin/delete/{id}", name="deletemedecin")
     */
    public function deleteMedecin($id, MedecinRepository $repos)
    {
        $medecin = $repos->find($id);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->remove($medecin);
        $entityManager->flush();

        return $this->redirectToRoute('listmedecin');
    }
    public function getLastMedecin()
    {
        $repos=$this->getDoctrine()->getRepository(Medecin::class);
        $medecinlast = $repos->findby([],['id'=>'DESC']);
        if($medecinlast==null){
            return $id=0;
        }
        else{
            return $medecinlast[0]->getId();
        }
    }
    
    
}