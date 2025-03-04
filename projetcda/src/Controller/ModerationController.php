<?php

namespace App\Controller;

use App\Entity\Commentaire;
use App\Repository\CommentaireRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

#[Route('/api/moderation')]
class ModerationController extends AbstractController
{
    #[Route('/commentaires/en-attente', name: 'api_commentaires_en_attente', methods: ['GET'])]
    public function getCommentairesEnAttente(CommentaireRepository $repository): JsonResponse
    {
        $commentaires = $repository->findBy(['statut' => 'en_attente']);
        return $this->json($commentaires, 200, [], ['groups' => 'read']);
    }

    #[Route('/commentaires/approuver/{id}', name: 'api_approuver_commentaire', methods: ['POST'])]
    public function approuverCommentaire(Commentaire $commentaire, EntityManagerInterface $entityManager): JsonResponse
    {
        $commentaire->setStatut('approuve');
        $entityManager->flush();
        return $this->json(['message' => 'Commentaire approuvé'], 200);
    }

    #[Route('/commentaires/rejeter/{id}', name: 'api_rejeter_commentaire', methods: ['POST'])]
    public function rejeterCommentaire(Commentaire $commentaire, EntityManagerInterface $entityManager): JsonResponse
    {
        $commentaire->setStatut('rejete');
        $entityManager->flush();
        return $this->json(['message' => 'Commentaire rejeté'], 200);
    }

    #[Route('/commentaires/approuves', name: 'api_commentaires_approuves', methods: ['GET'])]
    public function getCommentairesApprouves(CommentaireRepository $repository): JsonResponse
    {
        $commentaires = $repository->findBy(['statut' => 'approuve']);
        return $this->json($commentaires, 200, [], ['groups' => 'read']);
    }
}
