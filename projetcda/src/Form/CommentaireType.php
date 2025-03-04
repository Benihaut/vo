<?php

namespace App\Form;

use App\Entity\article;
use App\Entity\Commentaire;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType; 
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;


class CommentaireType extends AbstractType
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;  // Injection du service Security
    }

 public function buildForm(FormBuilderInterface $builder, array $options): void
{
    $builder
        ->add('datecommentaire', DateType::class, [
            'widget' => 'single_text',
        ])
        ->add('contenu', TextareaType::class);

    // Ajoutez le token CSRF de manière conditionnelle
    if (isset($options['csrf_token'])) {
        $builder->add('_token', HiddenType::class, [
            'data' => $options['csrf_token'],
        ]);
    }

    // Condition pour l'ajout du champ idarticle
    if ($this->security->isGranted('ROLE_ADMIN')) {
        $builder->add('idarticle', EntityType::class, [
            'class' => Article::class,
            'choice_label' => 'id',
        ]);
    }
}

// Mettez à jour configureOptions pour inclure csrf_token
public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
       'data_class' => Commentaire::class,
        'csrf_protection' => true,
        'csrf_field_name' => '_token',
        'csrf_token_id' => 'commentaire',  
    ]);
}

}
