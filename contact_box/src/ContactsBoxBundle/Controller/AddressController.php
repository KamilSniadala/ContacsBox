<?php

namespace ContactsBoxBundle\Controller;

use ContactsBoxBundle\Entity\Address;
use ContactsBoxBundle\Form\AddressType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddressController extends Controller
{
    /**
     * @Route("/{id}/addAddress", name="AddAddress", methods={"GET"})
     */
    public function addressFormAction($id)
    {
        $address= new Address();
        $form = $this->createForm(AddressType::class,$address);
        $em= $this->getDoctrine()->getManager();

        $usersRepo= $em -> getRepository('ContactsBoxBundle:User');
        $user = $usersRepo -> find($id);

        if (!$user)
        {
            return $this->render('responses.html.twig',['message'=>'user_dont_exist']);
        }

        return $this -> render('addingNewUserFormular.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/{id}/addAddress", methods={"POST"})
     */
    public function addAddressAction(Request $request, $id)
    {
        $em= $this->getDoctrine()->getManager();

        $usersRepo= $em -> getRepository('ContactsBoxBundle:User');
        $user = $usersRepo -> find($id);

        if (!$user)
        {
           return $this->render('responses.html.twig',['message'=>'user_dont_exist']);
        }

        $form= $this -> createForm(AddressType::class, new Address());
        $form->handleRequest($request);

        if ($form->isSubmitted())
        {

            $address = $form->getData();
            $address->setUserId($user);
            $em->persist($address);
            $em->flush();

            return $this->render('responses.html.twig',['message'=>'added_to_db']);
        }
        return $this->render('responses.html.twig',['message' => '404']);
    }

    /**
     * @Route("/modifyAddress/{id}", name="modifyAddress", methods={"GET"})
     */
    public function modifyAction($id)
    {
        $em = $this -> getDoctrine() -> getManager();

        $addressRepo = $em ->getRepository('ContactsBoxBundle:Address');
        $address = $addressRepo->find($id);

        if (!$address)
        {
            return $this->render('responses.html.twig', ['message' => 'address_dont_exist']);
        }

        $form = $this -> createForm(AddressType::class, $address);

        return $this -> render('addingNewUserFormular.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/modifyAddress/{id}", name="modifyActionPost", methods={"POST"})
     */
    public function modifyActionPost(Request $request,$id)
    {
        $em = $this -> getDoctrine() -> getManager();

        $addressRepo = $em ->getRepository('ContactsBoxBundle:Address');
        $address = $addressRepo->find($id);

        if (!$address)
        {
            return $this->render('responses.html.twig', ['message' => 'address_dont_exist']);
        }

        $form = $this -> createForm(AddressType::class, $address);
        $form -> handleRequest($request);

        if ($form->isSubmitted())
        {

            $address = $form->getData();
            $em->flush();

            return $this->render('responses.html.twig',['message'=>'updated_in_db']);
        }
        return $this->render('responses.html.twig',['message' => '404']);
    }

    /**
     * @Route("/deleteAddress/{id}", name="deleteAddress", methods={"GET"})
     */
    public function deleteAction($id)
    {
        $em = $this -> getDoctrine() -> getManager();

        $addressRepo = $em ->getRepository('ContactsBoxBundle:Address');
        $address = $addressRepo->find($id);

        if (!$address)
        {
            return $this->render('responses.html.twig', ['message' => 'address_dont_exist']);
        }

        $em -> remove($address);
        $em -> flush();

        return $this->render('responses.html.twig',['message' => 'deleted_from_db']);
    }
}