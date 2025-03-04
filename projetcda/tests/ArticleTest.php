<?php

namespace App\Tests;

use App\Entity\Article;
use App\Entity\User;
use App\Entity\Category;
use App\Entity\Commentaire;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    private Article $article;

    protected function setUp(): void
    {
        $this->article = new Article();
    }

    public function testGetterAndSetterForTitre(): void
    {
        $titre = "Test Article";
        $this->article->setTitre($titre);
        $this->assertEquals($titre, $this->article->getTitre());
    }

    public function testGetterAndSetterForContenue(): void
    {
        $contenue = "This is a test article content.";
        $this->article->setContenue($contenue);
        $this->assertEquals($contenue, $this->article->getContenue());
    }

    public function testGetterAndSetterForAuteur(): void
    {
        $auteur = "John Doe";
        $this->article->setAuteur($auteur);
        $this->assertEquals($auteur, $this->article->getAuteur());
    }

    public function testGetterAndSetterForDatearticle(): void
    {
        $date = new \DateTime();
        $this->article->setDatearticle($date);
        $this->assertEquals($date, $this->article->getDatearticle());
    }


    public function testGetterAndSetterForCategory(): void
    {
        $category = new Category();
        $this->article->setCategory($category);
        $this->assertEquals($category, $this->article->getCategory());
    }
}
