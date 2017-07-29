<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use AppBundle\Entity\Employee;
use AppBundle\Entity\Department;

class EmployeeController extends Controller
{
    /**
     * @Route("/getEmployees", name="getEmployees")
     */
    public function indexAction()
    {
        $employees = $this->getDoctrine()
                        ->getRepository(Employee::class)
                        ->findAll();

        return $this->render('default/employees.html.twig', array('employees' => $employees));
    }


    /**
     * @Route("/addEmployee", name="addEmployee")
     */
    public function addAction(Request $request)
    {
        $employee = new Employee();

        $departments = $this->getDoctrine()
                            ->getRepository(Department::class)
                            ->findAll();

        $form = $this->createFormBuilder($employee)
                    ->add('firstName', TextType::class)
                    ->add('lastName', TextType::class)
                    ->add('salary', NumberType::class)
                    ->add('department', EntityType::class, array('class' => 'AppBundle:Department', 'choice_label' => 'departmentName'))
                    ->add('save', SubmitType::class, array('label' => 'Add'))
                    ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();

            return $this->redirectToRoute('getEmployees');
        }

        return $this->render('default/form.html.twig', array('form' => $form->createView()));
    }


    /**
    * @Route("/editEmployee/{id}", name="editEmployee")
    */
    public function editAction($id, Request $request)
    {
        $employee = $this->getDoctrine()
                        ->getRepository(Employee::class)
                        ->find($id);

        $departments = $this->getDoctrine()->getRepository(Department::class)->findAll();

        $form = $this->createFormBuilder($employee)
                    ->add('firstName', TextType::class)
                    ->add('lastName', TextType::class)
                    ->add('salary', NumberType::class)
                    ->add('department', EntityType::class, array('class' => 'AppBundle:Department', 'choice_label' => 'departmentName'))
                    ->add('save', SubmitType::class, array('label' => 'Add'))
                    ->getForm();

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $employee = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($employee);
            $em->flush();

            return $this->redirectToRoute('getEmployees');
        }

        return $this->render('default/form.html.twig', array('form' => $form->createView()));
    }


    /**
    * @Route("/deleteEmployee/{id}", name="deleteEmployee")
    */
    public function deleteAction($id)
    {
        $employee = $this->getDoctrine()
                        ->getRepository(Employee::class)
                        ->find($id);

        $em = $this->getDoctrine()->getManager();
        $em->remove($employee);
        $em ->flush();

        return $this->redirectToRoute('getEmployees');
    }

}