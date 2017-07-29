<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Department;

class DepartmentController extends Controller
{
	/**
	 * @Route("/getDepartments", name="getDepartments")
	 */
	public function indexAction()
	{

		$departments = $this->getDoctrine()
							->getRepository(Department::class)
							->findAll();

		return $this->render('default/departments.html.twig', array('departments' => $departments));

	}

	/**
	 * @Route("/addDepartment", name="addDepartment")
	 */
	public function addAction(Request $request)
	{
		$department = new Department();

        $employees = $this->getDoctrine()
                        	->getRepository(Employee::class)
                            ->findAll();

        $form = $this->createFormBuilder($department)
                    ->add('departmentName', TextType::class)
                    ->add('manager', EntityType::class, array('class' => 'AppBundle:Employee', 'choice_label' => 'firstName'))
                    ->add('save', SubmitType::class, array('label' => 'Add'))
                    ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $department = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($department);
            $em->flush();

            return $this->redirectToRoute('getDepartments');
        }

        return $this->render('default/form.html.twig', array('form' => $form->createView()));
	}

	/**
	 * @Route("/editDepartment/{id}", name="editDepartment")
	 */
	public function editAction($id, Request $request)
	{
		$department = $this->getDoctrine()
						->getRepository(Department::class)
						->find($id);

		$form = $this->createFormBuilder($department)
					->add('departmentName', TextType::class)
					->add('manager', EntityType::class, array('class' => 'AppBundle:Employee', 'choice_label' => 'firstName'))
					->add('save', SubmitType::class, array('label' => 'Add'))
					->getForm();

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {
			$department = $form->getData();

			$em = $this->getDoctrine()->getManager();
			$em->persist($department);
			$em->flush();

			return $this->redirectToRoute('getDepartments');
		}

		return $this->render('default/form.html.twig', array('form' => $form->createView()));
	}

	/**
	 * @Route("/deleteDepartment/{id}", name="deleteDepartment")
	 */
	public function deleteAction($id)
	{
		$department = $this->getDoctrine()
						->getRepository(Department::class)
						->find($id);

		$em = $this->getDoctrine()->getManager();
		$em->remove($department);
		$em->flush();

		return $this->redirectToRoute('getDepartments');
	}

}