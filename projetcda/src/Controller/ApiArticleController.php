<?php

namespace App\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

#[Route('/api/articles')]
class ApiArticleController extends AbstractController
{
    #[Route('', name: 'api_article_index', methods: ['GET'])]
    public function index(ArticleRepository $articleRepository): JsonResponse
    {
        $articles = $articleRepository->findAll();
        return $this->json($articles, 200, [], ['groups' => 'article:read']);
    }

    #[Route('/{id}', name: 'api_article_show', methods: ['GET'])]
    public function show(Article $article): JsonResponse
    {
        return $this->json($article, 200, [], ['groups' => 'article:read']);
    }

    #[Route('', name: 'api_article_create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }

        $article = new Article();
        $article->setTitre($data['titre'] ?? '');
        $article->setContenue($data['contenue'] ?? '');
        $article->setAuteur($data['auteur'] ?? '');
        $article->setDatearticle(new \DateTime());

        $errors = $validator->validate($article);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $entityManager->persist($article);
        $entityManager->flush();

        return $this->json($article, 201, [], ['groups' => ['article:read', 'article:write']]);
    }

    #[Route('/{id}', name: 'api_article_update', methods: ['PUT'])]
    public function update(Request $request, Article $article, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            return $this->json(['error' => 'Invalid JSON'], 400);
        }

        $article->setTitre($data['titre'] ?? $article->getTitre());
        $article->setContenue($data['contenue'] ?? $article->getContenue());
        $article->setAuteur($data['auteur'] ?? $article->getAuteur());

        $errors = $validator->validate($article);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[] = $error->getMessage();
            }
            return $this->json(['errors' => $errorMessages], 400);
        }

        $entityManager->flush();

        return $this->json($article, 200, [], ['groups' => ['article:read', 'article:write']]);
    }

    #[Route('/{id}', name: 'api_article_delete', methods: ['DELETE'])]
    public function delete(Article $article, EntityManagerInterface $entityManager): JsonResponse
    {
        $entityManager->remove($article);
        $entityManager->flush();

        return $this->json(null, 204);
    }
}
