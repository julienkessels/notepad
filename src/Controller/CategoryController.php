<?php
namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Note;
use App\Entity\Category;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class CategoryController extends Controller
{
  /**
  * @Route("/categories", name="categories")
  */
  public function main()
  {
    $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findAll();
    return $this->render('categories/categories.html.twig', array(
        'categories' => $categories
    ));
  }


  /**
   * @Route("/newCategory", name="new_category")
   * @param Request $request
   * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
   */
  public function newCategory(Request $request)
  {

      $category = new Category();
      $category->setLibelle('Write a title');
      $form = $this->createFormBuilder($category)
          ->add('libelle', TextType::class)
          ->add('save', SubmitType::class, array('label' => 'Create Category'))
          ->getForm();

      $form->handleRequest($request);
      if ($form->isSubmitted() && $form->isValid()) {
          // $form->getData() holds the submitted values
          $category = $form->getData();
          $em = $this->getDoctrine()->getManager();
          $em->persist($category);
          $em->flush();
          return $this->redirectToRoute('categories');
      }


      return $this->render('categories/newCategory.html.twig', array(
          'form' => $form->createView(),
      ));
  }

  /**
       * @Route("/categories/edit/{id}", name="category_edit")
       * @param Request $request
       * @param Category $category
       * @return mixed
       */
      public function editCategory(Request $request, Category $category)
      {
          $form = $this->createFormBuilder($category)
              ->add('libelle', TextType::class)
              ->add('save', SubmitType::class, array('label' => 'Edit Category'))
              ->getForm();
          $form->handleRequest($request);
          if ($form->isSubmitted() && $form->isValid()) {
              // $form->getData() holds the submitted values
              $category = $form->getData();
              $em = $this->getDoctrine()->getManager();
              $em->persist($category);
              $em->flush();
              return $this->redirectToRoute('categories');
          }
          return $this->render('categories/newCategory.html.twig', array(
              'form' => $form->createView(),
          ));
      }

      /**
       * @Route("/categories/delete/{id}", name="category_delete")
       * @param Category $category
       * @return \Symfony\Component\HttpFoundation\RedirectResponse
       */
      public function delete(Category $category)
      {
          $em = $this->getDoctrine()->getManager();
          $em->remove($category);
          $em->flush();
          return $this->redirectToRoute('categories');
      }
  

}
?>
