<?php
namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Category;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;

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
  * @ORM\Column(type="string", length=50)
  * @Assert\NotBlank()
  * @Serializer\Type("string")
  */
  private $title;

  /**
  * @ORM\Column(type="text")
  * @Assert\NotBlank()
  * @Serializer\Type("string")
  */
  private $content;

  /**
  * @ORM\Column(type="datetime")
  * @Assert\NotBlank()
  * @Assert\Type("\DateTime")
  * @Serializer\Type("DateTime<'Y-m-d'>")
  */
  private $date;

  /**
  * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="notes")
  * @ORM\JoinColumn(name="category_id", referencedColumnName="id", nullable=false)
  * @Serializer\SerializedName("category")
  * @Serializer\Type("Entity<App\Entity\Category>")
  */
  private $category;

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
  public function getTitle()
  {
    return $this->title;
  }

  /**
  * @param $title
  */
  public function setTitle($title)
  {
    $this->title = $title;
  }

  /**
  * @return mixed
  */
  public function getContent()
  {
    return $this->content;
  }

  /**
  * @param $content
  */
  public function setContent($content)
  {
    $this->content = "<content>" . $content . "</content>";
  }

  /**
  * @param $content
  */
  public function setContentEdit($content)
  {
    $this->content = $content;
  }

  /**
  * @return mixed
  */
  public function getDate()
  {
    return $this->date;
  }

  /**
  * @param $date
  */
  public function setDate($date)
  {
    $this->date = $date;
  }

  /**
  * @return mixed
  */
  public function getCategory()
  {
    return $this->category;
  }

  /**
  * @param \App\Entity\Category $category
  */
  public function setCategory(Category $category)
  {
    $this->category = $category;
  }

  /**
  * @Assert\IsTrue(message = "Content is not valid")
  */
  public function isValid()
  {
    return true;
    $xsdValidation =
    "<xs:schema attributeFormDefault=\"unqualified\" elementFormDefault=\"qualified\" xmlns:xs=\"http://www.w3.org/2001/XMLSchema\">
      <xs:element name=\"content\">
      <xs:complexType mixed=\"true\">
      <xs:sequence>
      <xs:element type=\"xs:string\" name=\"tag\" maxOccurs=\"unbounded\" minOccurs=\"0\"/>
      </xs:sequence>
      </xs:complexType>
      </xs:element>
      </xs:schema>";
      $dom = new \DOMDocument();
      try {
        $xmlContent = $this->content ;
        $dom->loadXML($xmlContent);
        $dom->schemaValidateSource($xsdValidation);
      } catch ( \ErrorException $e)
      {
        echo "<h6> error validating content</h6>" . $e->getMessage();
        return false;
      }
      return true;
    }
  }
