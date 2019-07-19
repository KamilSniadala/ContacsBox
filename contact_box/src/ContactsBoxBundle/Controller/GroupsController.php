<?php

namespace ContactsBoxBundle\Controller;

use ContactsBoxBundle\Entity\Groups;
use ContactsBoxBundle\Form\GroupType;
use Doctrine\ORM\QueryBuilder;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class GroupsController extends Controller
{
    /**
     * @Route("/newGroup/", name="newGroup", methods={"GET"})
     */
    public function addNewAction()
    {
        $em = $this -> getDoctrine() -> getManager();

        $form = $this -> createForm(GroupType::class, new Groups());

        return $this -> render('addingNewUserFormular.html.twig',['form' => $form->createView()]);
    }

    /**
     * @Route("/newGroup/", name="newGroupPost", methods={"POST"})
     */
    public function addNewPostAction(Request $request)
    {
        $em = $this -> getDoctrine() -> getManager();

        $form = $this -> createForm(GroupType::class, new Groups());
        $form ->handleRequest($request);

        if ($form->isSubmitted())
        {
            $group = $form->getData();
            $em -> persist($group);
            $em -> flush();

            return $this->render('responses.html.twig', ['message' => 'added_to_db']);
        }
    }

    /**
     * @Route("/showGroup/all", name="showAllGroups", methods={"GET"})
     */
    public function showAllAction()
    {
        $em = $this->getDoctrine()->getManager();

        $groupsRepo = $em->getRepository("ContactsBoxBundle:Groups");
        $groups = $groupsRepo->findAll();

        return $this->render('showAllGroups.html.twig',['groups' => $groups]);
    }

    /**
     * @Route("/showGroup/{name}", name="showGroup", methods={"GET"})
     */
    public function showAction($name)
    {
        $em = $this->getDoctrine()->getManager();

        $groupsRepo = $em->getRepository("ContactsBoxBundle:Groups");
        $group = $groupsRepo->findOneBy(['name' => $name]);

        $query = $em->createQuery('SELECT u FROM ContactsBoxBundle:User u WHERE u.id=1');
        $query->getResult();
        






        return new Response('<html><body>Dupa</body>');
    }

}
