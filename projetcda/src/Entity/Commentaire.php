<?php

namespace App\Entity;

use App\Repository\CommentaireRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DateTimeImmutable;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CommentaireRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
    collectionOperations: [
        'get' => ['security' => "is_granted('ROLE_MODERATOR')"],
        'post' => ['security' => "is_granted('ROLE_USER')"]
    ],
    itemOperations: [
        'get' => ['security' => "is_granted('ROLE_MODERATOR')"],
        'put' => ['security' => "is_granted('ROLE_MODERATOR')"],
        'delete' => ['security' => "is_granted('ROLE_MODERATOR')"]
    ]
)]
class Commentaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    #[Groups(['read'])]
    private DateTimeImmutable $datecommentaire;

    #[ORM\ManyToOne(targetEntity: Article::class, inversedBy: 'idcommentaire')]
    #[ORM\JoinColumn(nullable: false, onDelete: "CASCADE")]
    #[Groups(['read', 'write'])]
    private Article $idarticle;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private string $contenu;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'commentaires')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['read', 'write'])]
    private User $user;

    #[ORM\Column(length: 20)]
    #[Groups(['read', 'write'])]
    private string $statut = 'en_attente';

    public function __construct(User $user, Article $article)
    {
        $this->datecommentaire = new DateTimeImmutable();
        $this->user = $user;
        $this->idarticle = $article;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDatecommentaire(): DateTimeImmutable
    {
        return $this->datecommentaire;
    }

    public function setDatecommentaire(DateTimeImmutable $datecommentaire): self
    {
        $this->datecommentaire = $datecommentaire;
        return $this;
    }

    public function getIdarticle(): Article
    {
        return $this->idarticle;
    }

    public function setIdarticle(Article $idarticle): self
    {
        $this->idarticle = $idarticle;
        return $this;
    }

    public function getContenu(): string
    {
        return $this->contenu;
    }

    public function setContenu(string $contenu): self
    {
        $this->contenu = $contenu;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getStatut(): string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): self
    {
        $this->statut = $statut;
        return $this;
    }
}
