<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BaseController extends Controller
{
  /**
  * @Route("/", name="base")
  */
  public function main()
  {
    return $this->redirectToRoute('notes');
  }
}
?>
