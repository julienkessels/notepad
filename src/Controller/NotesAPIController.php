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
use Symfony\Component\DomCrawler\Crawler;

class NotesAPIController extends Controller
{
  /**
  * @Route("/api/notes", name="api_notes")
  * @Method({"GET"})
  */
  public function getNotes()
  {
    $notes = $this->getDoctrine()
    ->getRepository(Note::class)
    ->findAll();
    $data = $this->get('jms_serializer')->serialize($notes, 'json');
    $response = new Response($data);
    $response->headers->set('Content-Type', 'application/json');
    return $response;
  }


  /**
  * @Route("/api/note/{id}", name="api_note_get")
  * @Method({"GET"})
  * @param $id
  * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
  */
  public function getNote($id)
  {
    $note = $this->getDoctrine()
    ->getRepository(Note::class)
    ->find($id);
    if ($note) {
      $data = $this->get('jms_serializer')->serialize($note, 'json');
      $response = new Response($data);
      $response->headers->set('Content-Type', 'application/json');
      $response->setStatusCode(Response::HTTP_OK);
      return $response;
    }
    else {
      return new JsonResponse(
        array(
          'status' => 'NOT FOUND',
          'message' => 'This note does not exist'
        )
      );
    }
  }


  /**
  * @Route("/api/note", name="api_note_create")
  * @Method({"POST"})
  * @param Request $request
  * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
  */
  public function newNote(Request $request)
  {
    $noteManager = $this->getDoctrine()
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
    $note = $this->get('jms_serializer')->deserialize($content, Note::class, 'json');
    if ($note->isValid()) {
      $note->setContent($note->getContent());
      $noteManager->persist($note);
      $noteManager->flush();
    }
    else {
      $response = new JsonResponse(
        array(
          'status' => 'Error',
          'message' => 'Content is not valid'
        )
      );
      $response->headers->set('Content-Type', 'application/json');
      $response->setStatusCode(Response::HTTP_OK);
      return $response;
    }

    $response = new JsonResponse(
      array(
        'status' => 'CREATED',
        'message' => 'The note has been created.'
      )
    );
    $response->headers->set('Content-Type', 'application/json');
    $response->setStatusCode(Response::HTTP_OK);
    return $response;
  }


  /**
  * @Route("/api/note/{id}", name="api_note_delete")
  * @Method({"DELETE"})
  * @param $id
  * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
  */
  public function deleteNote($id)
  {
    $note = $this->getDoctrine()
    ->getRepository(Note::class)
    ->find($id);
    if ($note) {
      $em = $this->getDoctrine()->getManager();
      $em->remove($note);
      $em->flush();
      return new JsonResponse(
        array(
          'status' => 'DELETED',
          'message' => 'This note has been deleted'
        )
      );
    }
    else {
      return new JsonResponse(
        array(
          'status' => 'NOT FOUND',
          'message' => 'This note does not exist'
        )
      );
    }
  }

  /**
  * @Route("/api/note/{id}", name="api_note_edit")
  * @Method({"PUT", "PATCH"})
  * @param Request $request
  * @param $id
  * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
  */
  public function editNote(Request $request, $id)
  {
    $noteManager = $this->getDoctrine()
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
    $note = $noteManager
    ->getRepository(Note::class)
    ->find($id);
    if ($note) {
      $note_request = $this->get('jms_serializer')->deserialize($content, Note::class, 'json');
      $note->setTitle($note_request->getTitle());
      $note->setContentEdit($note_request->getContent());
      $note->setDate($note_request->getDate());
      $note->setCategory($note_request->getCategory());
      $noteManager->flush();
      $response = new Response(
        array(
          'status' => 'UPDATED',
          'message' => 'The note has been updated.'
        )
      );
      $response->headers->set('Content-Type', 'application/json');
      $response->setStatusCode(Response::HTTP_OK);
      return $response;
    }
    else {
      return new JsonResponse(
        array(
          'status' => 'NOT FOUND',
          'message' => 'This note does not exist'
        )
      );
    }
  }

  /**
     * @Route("/api/note/tag/{tag}", name="get_api_tag")
     * @param Request $request
     * @Method({"GET"})
     * @return Response
     */
    public function getByTag ($tag) {
        $notes = $this->getDoctrine()
            ->getRepository(Note::class)
            ->findAll();
        $notesToRender = array();
        foreach($notes as $note){
            $xmlCrawler = new Crawler();
            $xmlCrawler->addXmlContent($note->getContent());
              $tagg = $xmlCrawler->filterXPath('//content/tag');
              if ($tagg->count()) {
                if ($tagg->text() == $tag){
                    $notesToRender [] = $note;
                }
              }
        }
        $data = $this->get('jms_serializer')->serialize($notesToRender, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        $response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }


}
