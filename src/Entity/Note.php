<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\NoteRepository")
 */
class Note
{
  /**
   * @ORM\Id
   * @ORM\GeneratedValue
   * @ORM\Column(type="integer")
   */
  private $id;

  /**
   * @ORM\Column(type="string", length=100)
   */
  private $name;

  /**
   * @ORM\Column(type="decimal", scale=2, nullable=true)
   */
  private $price;


  /**
   * @param $name
   */
  public function setName($name)
  {
      $this->name = $name;
  }

  /**
   * @param $price
   */
  public function setPrice($price)
  {
      $this->price = $price;
  }

}
