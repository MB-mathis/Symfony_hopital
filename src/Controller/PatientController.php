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
use App\Security\Voter\PatientVoter;

#[Route('/patient')]
final class PatientController extends AbstractController {
    public const ROUTE_LIST = 'patient_list';
    public const ROUTE_CREATE = 'patient_create';
    public const ROUTE_UPDATE = 'patient_update';
    public const ROUTE_DELETE = 'patient_delete';
    public const ROUTE_SHOW = 'patient_show';
    public const ROUTE_DOSSIER = 'patient_medical_record';

    #[Route(name: self::ROUTE_LIST, methods: ['GET'])]
    public function index(PatientRepository $patientRepository): Response {
        return $this->render('patient/index.html.twig', [
            'patients' => $patientRepository->findPatientsByUser($this->getUser()),
        ]);
    }

    #[Route('/new', name: self::ROUTE_CREATE, methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response {
        $patient = new Patient();
        $form = $this->createForm(PatientType::class, $patient,['can_edit_shares' => true,]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $patient->setCreatedBy($this->getUser());
            $entityManager->persist($patient);
            $entityManager->flush();

            return $this->redirectToRoute(self::ROUTE_LIST, [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('patient/new.html.twig', [
            'patient' => $patient,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: self::ROUTE_SHOW, methods: ['GET'])]
    public function show(Patient $patient): Response {
        if (!$this->isGranted(PatientVoter::VIEW, $patient)) {
            throw $this->createAccessDeniedException('Vous n’êtes pas autorisé à consulter ce patient.'); // mettre une redirection vers la liste des patients
        }
        return $this->render('patient/show.html.twig', [
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}/edit', name: self::ROUTE_UPDATE, methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $entityManager,
        Patient $patient
    ): Response {
        if ($patient->getId() && !$this->isGranted(PatientVoter::EDIT, $patient)) {
            throw $this->createAccessDeniedException('Vous n’êtes pas autorisé à modifier ce patient.'); // mettre une redirection vers la page de consultation du patient ou la liste des patients
        }

        $form = $this->createForm(PatientType::class, $patient, [
            'can_edit_shares' => $this->isGranted(PatientVoter::SHARE, $patient),
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($patient);
            $entityManager->flush();
            $this->addFlash('success', 'Patient mis à jour avec succès.');

            return $this->redirectToRoute(self::ROUTE_LIST);
        }

        return $this->render('patient/edit.html.twig', [
            'form' => $form->createView(),
            'patient' => $patient,
        ]);
    }

    #[Route('/{id}', name: self::ROUTE_DELETE, methods: ['POST'])]
    public function delete(
        Request $request,
        Patient $patient,
        EntityManagerInterface $em
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $patient->getId(), $request->getPayload()->getString('_token'))) {

            foreach ($patient->getDossiersMedicaux() as $dossier) {
                if (count($dossier->getGreffes()) > 0) {
                    throw new \DomainException('Impossible de supprimer ce patient : des greffes sont associées.');
                }
            }

            if (count($patient->getDossiersMedicaux()) > 0) {
                throw new \DomainException('Impossible de supprimer ce patient : des dossiers médicaux existent.');
            }

            $em->remove($patient);
            $em->flush();
        }

        return $this->redirectToRoute(self::ROUTE_LIST);
    }

    #[Route('/{id}/dossier', name: self::ROUTE_DOSSIER, methods: ['GET'])]
    public function dossier(Patient $patient, DossierMedicalRepository $dossierRepo): Response
    {
        if (!$this->isGranted(PatientVoter::VIEW, $patient)) {
            throw $this->createAccessDeniedException('Vous n’êtes pas autorisé à consulter ce patient.');
        }

        $dossier = $dossierRepo->findFullByPatient($patient);

        if (!$dossier) {
            $this->addFlash('warning', 'Aucun dossier médical trouvé pour ce patient.');
            return $this->redirectToRoute(self::ROUTE_LIST);
        }

        return $this->render('patient/dossier.html.twig', [
            'patient' => $patient,
            'dossier' => $dossier,
        ]);
    }
}
