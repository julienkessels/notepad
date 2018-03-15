<?php
namespace App\Entity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Note;
/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=50)
     */
    private $libelle;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Note", mappedBy="category", cascade={"remove"})
     */
    private $notes;
    /**
     * Category constructor.
     */
    public function __construct()
    {
        $this->notes = new ArrayCollection();
    }
    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * @return mixed
     */
    public function getLibelle()
    {
        return $this->libelle;
    }
    /**
     * @param $libelle
     */
    public function setLibelle($libelle)
    {
        $this->libelle = $libelle;
    }
    /**
     * @return Collection|Note[]
     */
    public function getNotes()
    {
        return $this->notes;
    }
}
