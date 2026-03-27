<?php

namespace App\Controller;

use App\Entity\Patient;
use App\Form\PatientType;
use App\Repository\PatientRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Repository\DossierMedicalRepository;


#[Route('/patient')]
final class PatientController extends AbstractController {
    #[Route(name: 'app_patient_index', methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response {
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findPatientsByUser($this->getUser()),
        ]);
    }

    #[Route('/new', name: 'app_patient_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $patient->setCreatedBy($this->getUser());
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_show', methods: ['GET'])]
    public function show(Patient $patient): Response {
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

   #[Route('/{id}/edit', name: 'app_patient_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Patient $patient,
        EntityManagerInterface $entityManager,
    ): Response {
        $form = $this->createForm(PatientType::class, $patient);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success', 'Patient mis à jour avec succès.');

            return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/edit.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_patient_delete', methods: ['POST'])]
    public function delete(Request $request, Patient $patient, EntityManagerInterface $entityManager): Response {
        if ($this->isCsrfTokenValid('delete' . $patient->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($patient);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_patient_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/dossier', name: 'app_patient_dossier', methods: ['GET'])]
    public function dossier(Patient $patient, DossierMedicalRepository $dossierRepo): Response
    {
        $dossier = $dossierRepo->findByPatient($patient);

        if (!$dossier) {
            $this->addFlash('warning', 'Aucun dossier médical trouvé pour ce patient.');
            return $this->redirectToRoute('app_patient_index');
        }

        return $this->render('patient/dossier.html.twig', [
            'patient' => $patient,
            'dossier' => $dossier,
        ]);
    }
}
