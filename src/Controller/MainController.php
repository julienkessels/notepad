<?php
namespace App\Controller;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Note;

class MainController extends Controller
{
  /**
  * @Route("/")
  */
  public function helloAction()
  {
    /*
    $note = new Note();
    $note->setName('Write a title');
    $note->setPrice(10);

    $em = $this->getDoctrine()->getManager();
    $em->persist($note);
    $em->flush();
*/
    $name = 'Julien';
    return $this->render('main.html.twig', array('name' => $name));
  }
}
?>
