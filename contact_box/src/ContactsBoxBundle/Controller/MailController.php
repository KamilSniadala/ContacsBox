<?php

namespace ContactsBoxBundle\Controller;

use ContactsBoxBundle\Form\AddressType;
use ContactsBoxBundle\Form\MailType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ContactsBoxBundle\Entity\Mail;
use Symfony\Component\HttpFoundation\Request;

class MailController extends Controller
{
    /**
     * @Route("/{id}/addMail", name="AddMail", methods={"GET"})
     */
    public function MailFormAction($id)
    {
      $mail = new Mail();
      $form = $this -> createForm(MailType::class, $mail);

      $em = $this -> getDoctrine() -> getManager();
      $usersRepo= $em -> getRepository('ContactsBoxBundle:User');
      $user = $usersRepo -> find($id);

      if (!$user)
      {
            return $this->render('responses.html.twig',['message'=>'user_dont_exist']);
      }
        return $this -> render('addingNewUserFormular.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/{id}/addMail",name="AddMailPost", methods={"POST"})
     */
    public function AddMailAction(Request $request, $id)
    {
        $em = $this -> getDoctrine() ->getManager();


        $usersRepo= $em -> getRepository('ContactsBoxBundle:User');
        $user = $usersRepo -> find($id);

        if (!$user)
        {
            return $this->render('responses.html.twig',['message'=>'user_dont_exist']);
        }

        $form= $this -> createForm(MailType::class, new Mail());
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {

            $mail = $form->getData();
            $mail->setUserId($user);
            $em->persist($mail);
            $em->flush();

            return $this->render('responses.html.twig',['message'=>'added_to_db']);
        }
        return $this->render('responses.html.twig',['message' => '404']);
    }
    //Tutaj wkleilem
    /**
     * @Route("/modifyEmail/{id}", name="modifyMail", methods={"GET"})
     */
    public function modifyAction($id)
    {
        $em = $this -> getDoctrine() -> getManager();

        $mailsRepo = $em ->getRepository('ContactsBoxBundle:Mail');
        $mail = $mailsRepo->find($id);

        if (!$mail)
        {
            return $this->render('responses.html.twig', ['message' => 'address_dont_exist']);
        }

        $form = $this -> createForm(MailType::class, $mail);

        return $this -> render('addingNewUserFormular.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/modifyEmail/{id}", name="modifyMailPost", methods={"POST"})
     */
    public function modifyActionPost(Request $request,$id)
    {
        $em = $this -> getDoctrine() -> getManager();

        $mailsRepo = $em ->getRepository('ContactsBoxBundle:Mail');
        $mail = $mailsRepo->find($id);

        if (!$mail)
        {
            return $this->render('responses.html.twig', ['message' => 'address_dont_exist']);
        }

        $form = $this -> createForm(MailType::class, $mail);
        $form -> handleRequest($request);

        if ($form->isSubmitted())
        {

            $mail = $form->getData();
            $em->flush();

            return $this->render('responses.html.twig',['message'=>'updated_in_db']);
        }
        return $this->render('responses.html.twig',['message' => '404']);
    }

    /**
     * @Route("/deleteMail/{id}", name="deleteMail", methods={"GET"})
     */
    public function deleteAction($id)
    {
        $em = $this -> getDoctrine() -> getManager();

        $mailsRepo = $em ->getRepository('ContactsBoxBundle:Mail');
        $mail = $mailsRepo->find($id);

        if (!$mail)
        {
            return $this->render('responses.html.twig', ['message' => 'address_dont_exist']);
        }

        $em -> remove($mail);
        $em -> flush();

        return $this->render('responses.html.twig',['message' => 'deleted_from_db']);
    }
}
