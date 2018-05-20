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

  /**
  * @Route("/api/categories/{id}", name="api_category_get")
  * @Method({"GET"})
  * @param $id
  * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
  */
  public function getCategory($id)
  {
    $category = $this->getDoctrine()
    ->getRepository(Category::class)
    ->find($id);
    if ($category) {
      $data = $this->get('jms_serializer')->serialize($category, 'json');
      $response = new Response($data);
      $response->headers->set('Content-Type', 'application/json');
      $response->setStatusCode(Response::HTTP_OK);
      return $response;
    }
    else {
      return new JsonResponse(
        array(
          'status' => 'NOT FOUND',
          'message' => 'Category does not exist'
        )
      );
    }
  }

  /**
  * @Route("/api/categories", name="api_category_create")
  * @Method({"POST"})
  * @param Request $request
  * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
  */
  public function newCategory(Request $request)
  {
    $categoryManager = $this->getDoctrine()
    ->getManager();
    $content = $request->getContent();
    if (empty($content))
    {
      return new JsonResponse(
        array(
          'status' => 'EMPTY',
          'message' => 'The body of this request is empty.'
        )
      );
    }
    $category = $this->get('jms_serializer')->deserialize($content, Category::class, 'json');
    $categoryManager->persist($category);
    $categoryManager->flush();
    $response = new JsonResponse(
      array(
        'status' => 'CREATED',
        'message' => 'Category has been created.'
      )
    );
    $response->headers->set('Content-Type', 'application/json');
    $response->headers->set('Access-Control-Allow-Origin', '*');
    $response->setStatusCode(Response::HTTP_CREATED);
    return $response;
  }

  /**
  * @Route("/api/categories/{id}", name="api_category_delete")
  * @Method({"DELETE"})
  * @param $id
  * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
  */
  public function deleteCategory($id)
  {
    $category = $this->getDoctrine()
    ->getRepository(Category::class)
    ->find($id);
    if ($category) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($category);
      $em->flush();
      $response = new JsonResponse(
        array(
          'status' => 'DELETED',
          'message' => 'Category has been deleted'
        )
      );
      $response->headers->set('Content-Type', 'application/json');
      return $response;
    }
    else {
      return new JsonResponse(
        array(
          'status' => 'NOT FOUND',
          'message' => 'Category does not exist'
        )
      );
    }
  }

  /**
  * @Route("/api/categories/{id}", name="api_category_edit")
  * @Method({"PUT", "PATCH"})
  * @param Request $request
  * @param $id
  * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
  */
  public function editCategory(Request $request, $id)
  {
    $categoryManager = $this->getDoctrine()
    ->getManager();
    $content = $request->getContent();
    if (empty($content))
    {
      return new JsonResponse(
        array(
          'status' => 'EMPTY',
          'message' => 'Body of this request is empty.'
        )
      );
    }
    $category = $categoryManager
    ->getRepository(Category::class)
    ->find($id);
    if ($category) {
      $category_request = $this->get('jms_serializer')->deserialize($content, Category::class, 'json');
      $category->setLibelle($category_request->getLibelle());
      $categoryManager->flush();
      $response = new JsonResponse(
        array(
          'status' => 'UPDATED',
          'message' => 'Category has been updated.'
        )
      );
      $response->headers->set('Content-Type', 'application/json');
      $response->headers->set('Access-Control-Allow-Origin', '*');
      $response->setStatusCode(Response::HTTP_OK);
      return $response;
    }
    else {
      return new JsonResponse(
        array(
          'status' => 'NOT FOUND',
          'message' => 'Category does not exist'
        )
      );
    }
  }
}
