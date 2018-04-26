<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use App\Entity\Note;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;

class CategoriesAPIController extends Controller
{
  /**
  * @Route("/api/categories", name="api_categories")
  * @Method({"GET"})
  */
  public function getCategories()
  {
    $categories = $this->getDoctrine()
    ->getRepository(Category::class)
    ->findAll();
    $data = $this->get('jms_serializer')->serialize($categories, 'json');
    $response = new Response($data);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }

}
