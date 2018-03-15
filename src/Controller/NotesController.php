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

class NotesController extends Controller
{
  /**
  * @Route("/notes", name="notes")
  */
  public function main()
  {
    $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findAll();
    return $this->render('notes/notes.html.twig', array(
        'notes' => $notes
    ));
  }


    /**
     * @Route("/newNote", name="new_note")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function newNote(Request $request)
    {

        $note = new Note();
        $note->setTitle('Write a title');
        $note->setDate(new \DateTime('today'));
        $form = $this->createFormBuilder($note)
            ->add('title', TextType::class)
            ->add('date', DateType::class)
            ->add('content', TextType::class)
            ->add('category', EntityType::class, array(
                'class' => Category::class,
                'choice_label' => 'libelle'
            ))
            ->add('save', SubmitType::class, array('label' => 'Create Note'))
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // $form->getData() holds the submitted values
            $note = $form->getData();
            $em = $this->getDoctrine()->getManager();
            $em->persist($note);
            $em->flush();
            return $this->redirectToRoute('notes');
        }


        return $this->render('notes/newNote.html.twig', array(
            'form' => $form->createView(),
        ));
    }

}
?>
