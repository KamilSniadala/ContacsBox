<?php

namespace ContactsBoxBundle\Controller;

use ContactsBoxBundle\Entity\PhoneNumber;
use ContactsBoxBundle\Form\AddressType;
use ContactsBoxBundle\Form\PhoneNumberType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

class PhoneNumberController extends Controller
{
    /**
     * @Route("/{id}/addPhone", name="AddPhone", methods={"GET"})
     */
    public function PhoneNumberFormAction($id)
    {
        $phoneNumber = new PhoneNumber();
        $form = $this->createForm(PhoneNumberType::class, $phoneNumber);
        $em = $this->getDoctrine()->getManager();

        $usersRepo = $em->getRepository('ContactsBoxBundle:User');
        $user = $usersRepo->find($id);

        if (!$user) {
            return $this->render('responses.html.twig', ['message' => 'user_dont_exist']);
        }

        return $this->render('addingNewUserFormular.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/{id}/addPhone", methods={"POST"})
     */
    public function AddPhoneNumberAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $usersRepo = $em->getRepository('ContactsBoxBundle:User');
        $user = $usersRepo->find($id);

        if (!$user) {
            return $this->render('responses.html.twig', ['message' => 'user_dont_exist']);
        }

        $form = $this->createForm(PhoneNumberType::class, new PhoneNumber());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $phoneNumber = $form->getData();
            $phoneNumber->setUserId($user);
            $em->persist($phoneNumber);
            $em->flush();

            return $this->render('responses.html.twig', ['message' => 'added_to_db']);
        }
        return $this->render('responses.html.twig', ['message' => '404']);
    }
    //Tu wkleilem

    /**
     * @Route("/modifyPhone/{id}", name="modifyPhone", methods={"GET"})
     */
    public function modifyAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $phoneNumbersRepo = $em->getRepository('ContactsBoxBundle:PhoneNumber');
        $phoneNumber = $phoneNumbersRepo->find($id);

        if (!$phoneNumber) {
            return $this->render('responses.html.twig', ['message' => 'address_dont_exist']);
        }

        $form = $this->createForm(PhoneNumberType::class, $phoneNumber);

        return $this->render('addingNewUserFormular.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/modifyPhone/{id}", name="modifyPhonePost", methods={"POST"})
     */
    public function modifyActionPost(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $phoneNumbersRepo = $em->getRepository('ContactsBoxBundle:PhoneNumber');
        $phoneNumber = $phoneNumbersRepo->find($id);

        if (!$phoneNumber) {
            return $this->render('responses.html.twig', ['message' => 'address_dont_exist']);
        }

        $form = $this->createForm(PhoneNumberType::class, $phoneNumber);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {

            $phoneNumber = $form->getData();
            $em->flush();

            return $this->render('responses.html.twig', ['message' => 'updated_in_db']);
        }
        return $this->render('responses.html.twig', ['message' => '404']);
    }

    /**
     * @Route("/deletePhone/{id}", name="deletePhone", methods={"GET"})
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $phoneNumbersRepo = $em->getRepository('ContactsBoxBundle:PhoneNumber');
        $phoneNumber = $phoneNumbersRepo->find($id);

        if (!$phoneNumber) {
            return $this->render('responses.html.twig', ['message' => 'address_dont_exist']);
        }


        $em->remove($phoneNumber);
        $em->flush();

        return $this->render('responses.html.twig', ['message' => 'deleted_from_db']);
    }
}
