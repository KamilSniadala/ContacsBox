<?php

namespace ContactsBoxBundle\Controller;

use ContactsBoxBundle\Entity\Address;
use ContactsBoxBundle\Entity\User;
use ContactsBoxBundle\Form\GroupListType;
use ContactsBoxBundle\Form\UsersAndGroupsType;
use ContactsBoxBundle\Form\UserType;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * @Route("/new/", methods={"GET"}, name="newUser")
     */
    public function newFormAction()
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        return $this->render('addingNewUserFormular.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/new/", methods={"POST"})
     */
    public function newAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ContactsBoxBundle:User');

        $form = $this->createForm(UserType::class, new User());
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();

            return $this->render('responses.html.twig', ['message' => 'added_to_db']);
        }

        return $this->render('responses.html.twig', ['message' => '404']);
    }

    /**
     * @Route("/modify/{id}", methods={"GET"}, name="modifyUser")
     */
    public function updateFormularAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ContactsBoxBundle:User');


        $user = $repo->find($id);

        if (!$user) {
            return new Response('<html><body>User o takim id nie istnieje</body>');
        }

        $form = $this->createForm(UserType::class, $user);

        return $this->render('addingNewUserFormular.html.twig', ['form' => $form->createView()]);

    }

    /**
     * @Route("/modify/{id}", methods={"POST"})
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ContactsBoxBundle:User');
        $user = $repo->find($id);

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em->flush();

            return $this->render('responses.html.twig', ['message' => 'updated_in_db']);
        }
    }

    /**
     * @Route("/delete/{id}", methods={"GET"}, name="deleteUser")
     */
    public function deleteAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $usersRepo = $em->getRepository('ContactsBoxBundle:User');
        $user = $usersRepo->find($id);

        $addressesRepo = $em->getRepository('ContactsBoxBundle:Address');
        $addresses = $addressesRepo->find($user);

        var_dump($addresses);

        if (!$user) {
            return $this->render('responses.html.twig', ['message' => 'user_dont_exist']);
        }


        $em->remove($user);
        $em->flush();

        return $this->render('responses.html.twig', ['message' => 'deleted_from_db']);
    }

    /**
     * @Route("/{id}", methods={"GET"}, name="showUser")
     */
    public function showAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $usersRepo = $em->getRepository('ContactsBoxBundle:User');
        $user = $usersRepo->find($id);


        if (!$user) {
            return $this->render('responses.html.twig', ['message' => 'user_dont_exist']);
        }

        return $this->render('showUserAndExtendMain.html.twig', ['user' => $user]);
    }

    /**
     * @Route("/", methods={"GET"}, name="showAllUsers")
     */
    public function showAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('ContactsBoxBundle:User');
        $users = $repo->findAll();

        return $this->render('showAllUsers.html.twig', ['users' => $users]);
    }

    /**
     * @Route("/addUserToGroup/{id}", name="addUserToGroup", methods={"GET"})
     */
    public function addUserToGroupAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $usersRepo = $em->getRepository('ContactsBoxBundle:User');
        $user = $usersRepo->find($id);

        $form = $this->createForm(UsersAndGroupsType::class);
        if (!$user) {
            return $this->render('responses.html.twig', ['message' => 'user_dont_exist']);
        }

        return $this->render('addingNewUserFormular.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/addUserToGroup/{id}", name="addUserToGroupPost", methods={"POST"})
     */
    public function addUserToGroupPostAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $usersRepo = $em->getRepository('ContactsBoxBundle:User');

        $user = $usersRepo->find($id);
        
        if (!$user) {
            return $this->render('responses.html.twig', ['message' => 'user_dont_exist']);
        }

        $form = $this->createForm(UsersAndGroupsType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $user = $form->getData();
            $em->persist($user);
            $em->flush();

            return $this->render('responses.html.twig', ['message' => 'updated_in_db']);
        }

    }

    /**
     * @Route("/groupList/", name="groupList", methods={"GET"})
     */
    public function groupListAction()
    {
        $form = $this->createForm(GroupListType::class);

        return $this->render('addingNewUserFormular.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/groupList/", name="groupListPost", methods={"POST"})
     */
    public function groupListPostAction(Request $request)
    {
        /** @var EntityManagerInterface $em */
        $em = $this->getDoctrine()->getManager();

        $groupId=$request->request->get('group_list')['groups'];
        return new Response('<html><body></body>');
    }


}
