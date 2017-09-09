<?php

namespace Yannick\CrudBundle\Controller;

use Yannick\CrudBundle\Entity\Users;
use Yannick\CrudBundle\Entity\Departements;
use  Yannick\CrudBundle\Form\UsersType;
use  Yannick\CrudBundle\Form\UsersEditType;
use  Yannick\CrudBundle\Form\ DepartementsType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UsersController extends Controller
{
    public function indexAction()
    {
        return $this->render('YannickCrudBundle:Users:index.html.twig');

    }


    public function editAction($id, Request $request){
    $em = $this->getDoctrine()->getManager();

    $users = $em->getRepository('YannickCrudBundle:Users')->find($id);

    if (null === $users) {
      throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
    }

    $form = $this->get('form.factory')->create(UsersEditType::class, $users);

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      // Inutile de persister ici, Doctrine connait déjà notre annonce
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien modifié.');

      return $this->redirectToRoute('yannick_crud_view', array('id' => $users->getId()));
    }
    $ems = $this->getDoctrine()->getManager();
      $deps = $ems->getRepository('YannickCrudBundle:Departements')->findAll();
    return $this->render('YannickCrudBundle:Users:edit.html.twig', array(
      'users' => $users,
      'form'   => $form->createView(),
      'deps' =>$deps,
    ));
  }

    public function addAction(Request $request)
    {
    $users = new Users();


    $form   = $this->get('form.factory')->create(UsersType::class, $users);


    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em = $this->getDoctrine()->getManager();
      $em->persist($users);
      $em->flush();

      $request->getSession()->getFlashBag()->add('notice', 'Utilisateur bien enregistré.');

      return $this->redirectToRoute('yannick_crud_view', array('id' => $users->getId()));
    }
    $ems = $this->getDoctrine()->getManager();
    $deps = $ems->getRepository('YannickCrudBundle:Departements')->findAll();

    return $this->render('YannickCrudBundle:Users:add.html.twig', array(
      'form' => $form->createView(),
      'deps' =>$deps,
      
    ));
    
    }

    public function viewAction($id){
        $repository_users = $this->getDoctrine()
        ->getManager()
        ->getRepository('YannickCrudBundle:Users')
        ;
        $em = $this->getDoctrine()->getManager();

        $users = $repository_users->find($id);
        $deps = $em->getRepository('YannickCrudBundle:Departements')->findAll();




        return $this->render('YannickCrudBundle:Users:viewlist.html.twig', array('users'=>$users,'deps'=>$deps));

    }

    public function deleteAction(Request $request,$id){
  
 
    $em = $this->getDoctrine()->getManager();

    $users = $em->getRepository('YannickCrudBundle:Users')->find($id);

    if (null === $users) {
      throw new NotFoundHttpException("L'utilisateur d'id ".$id." n'existe pas.");
    }

    // On crée un formulaire vide, qui ne contiendra que le champ CSRF
    // Cela permet de protéger la suppression d'annonce contre cette faille
    $form = $this->get('form.factory')->create();

    if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
      $em->remove($users);
      $em->flush();

      $request->getSession()->getFlashBag()->add('info', "L'utilisateur a bien été supprimé.");

      return $this->redirectToRoute('yannick_crud_homepage');
    }
    
    return $this->render('YannickCrudBundle:Users:delete.html.twig', array(
      'users' => $users,
      'form'   => $form->createView(),
        
        ));
  }

  public function listAction(){
    $em = $this->getDoctrine()->getManager();
    $users = $em->getRepository('YannickCrudBundle:Users')->findAll();
    $deps = $em->getRepository('YannickCrudBundle:Departements')->findAll();
    return $this->render('YannickCrudBundle:Users:list.html.twig', array(
          'users'=>$users,
          'deps'=>$deps,
          
          ));
  }
}