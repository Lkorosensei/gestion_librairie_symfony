<?php

namespace App\Entity;

use App\Repository\CommandesRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use App\Entity\Livres;
use App\Entity\Fournisseurs;

#[ORM\Entity(repositoryClass: CommandesRepository::class)]
#[ORM\Table(name:"commandes")]
class Commandes
{
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy:'IDENTITY')]
    #[ORM\Column(name: "id_commande", type: "integer", nullable: false)]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity:Livres::class)]
    #[ORM\JoinColumn(nullable: false, name:'Id_Livre', referencedColumnName: 'Id_Livre')]
    private ?Livres $livres = null;

    #[ORM\ManyToOne(targetEntity:Fournisseurs::class)]
    #[ORM\JoinColumn(nullable: false, name:'Id_fournisseur', referencedColumnName:'Id_fournisseur')]
    private ?Fournisseurs $fournisseur = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $Date_achat = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 6, scale: 2)]
    private ?string $Prix_achat = null;

    #[ORM\Column(type: Types::BIGINT)]
    private ?string $Nbr_exemplaires = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLivre(): ?Livres
    {
        // return $this->Id_Livre;
        return $this->livres;
    }

    public function setLivre(?Livres $livres): static
    {
        $this->livres = $livres;

        return $this;
    }

    public function getFournisseur(): ?Fournisseurs
    {
        return $this->fournisseur;
    }

    public function setFournisseur(?Fournisseurs $fournisseur): static
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getDateAchat(): ?\DateTimeInterface
    {
        return $this->Date_achat;
    }

    public function setDateAchat(?\DateTimeInterface $Date_achat): static
    {
        $this->Date_achat = $Date_achat;

        return $this;
    }

    public function getPrixAchat(): ?string
    {
        return $this->Prix_achat;
    }

    public function setPrixAchat(string $Prix_achat): static
    {
        $this->Prix_achat = $Prix_achat;

        return $this;
    }

    public function getNbrExemplaires(): ?string
    {
        return $this->Nbr_exemplaires;
    }

    public function setNbrExemplaires(string $Nbr_exemplaires): static
    {
        $this->Nbr_exemplaires = $Nbr_exemplaires;

        return $this;
    }
}
