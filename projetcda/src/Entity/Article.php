<?php

namespace App\Entity;

use App\Repository\ArticleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: ArticleRepository::class)]
class Article
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['article:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:read', 'article:write'])]
    private ?string $titre = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['article:read', 'article:write'])]
    private ?string $contenue = null;

    #[ORM\Column(length: 255)]
    #[Groups(['article:read', 'article:write'])]
    private ?string $auteur = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Groups(['article:read'])]
    private ?\DateTimeInterface $datearticle = null;

    #[ORM\OneToMany(targetEntity: Commentaire::class, mappedBy: 'idarticle', cascade: ['persist', 'remove'])]
    #[Groups(['article:read'])]
    private Collection $idcommentaire;

    #[ORM\ManyToOne(targetEntity: Category::class, inversedBy: 'articles')]
    #[ORM\JoinColumn(nullable: true, onDelete: "SET NULL")]
    #[Groups(['article:read', 'article:write'])]
    private ?Category $category = null;

    // Nouveau champ pour l'image
    #[ORM\Column(type: "string", length: 255, nullable: true)]
    #[Groups(['article:read', 'article:write'])]
    private ?string $image = null;

    public function __construct()
    {
        $this->idcommentaire = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): static
    {
        $this->titre = $titre;

        return $this;
    }

    public function getContenue(): ?string
    {
        return $this->contenue;
    }

    public function setContenue(string $contenue): static
    {
        $this->contenue = $contenue;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): static
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getDatearticle(): ?\DateTimeInterface
    {
        return $this->datearticle;
    }

    public function setDatearticle(\DateTimeInterface $datearticle): static
    {
        $this->datearticle = $datearticle;

        return $this;
    }

    /**
     * @return Collection<int, Commentaire>
     */
    public function getIdcommentaire(): Collection
    {
        return $this->idcommentaire;
    }

    public function addIdcommentaire(Commentaire $idcommentaire): self
    {
        if (!$this->idcommentaire->contains($idcommentaire)) {
            $this->idcommentaire->add($idcommentaire);
            $idcommentaire->setIdarticle($this);
        }

        return $this;
    }

    public function removeIdcommentaire(Commentaire $idcommentaire): self
    {
        if ($this->idcommentaire->removeElement($idcommentaire)) {
            // set the owning side to null (unless already changed)
            if ($idcommentaire->getIdarticle() === $this) {
                $idcommentaire->setIdarticle(null);
            }
        }

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): static
{
$this->category = $category;

return$this;}

public function getImage(): ?string
{
    return $this->image;
}

public function setImage(?string $image): static
{
    $this->image = $image;
    return $this;
}


}
