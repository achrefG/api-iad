<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ContactController extends AbstractController
{
    #------------GET Request----CREATE NEW CONTACT------------------------
    /**
     * @Route("/contact", name="app_contact", methods={"GET"})
     */
    public function index(): Response
    {
        $contacts = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->findAll();
        $data = [];

        foreach ($contacts as $contact) {
            $data[] = [
                'id' => $contact->getId(),
                'name' => $contact->getName(),
                'firstName' => $contact->getFirstName(),
                'email' => $contact->getEmail(),
                'address' => $contact->getAddress(),
                'phone' => $contact->getPhone(),
                'age' => $contact->getAge(),
            ];
        }
        return $this->json($data);
    }

    #------------POST Request----CREATE NEW CONTACT------------------------
    /**
     * @Route("/contact", name="contact_new", methods={"POST"})
     */
    public function new(Request $request): Response
    {
        $entityManager = $this->getDoctrine()->getManager();

        $contact = new Contact();
        $contact->setName($request->request->get('name'));
        $contact->setFirstName($request->request->get('firstName'));
        $contact->setEmail($request->request->get('email'));
        $contact->setAddress($request->request->get('address'));
        $contact->setPhone($request->request->get('phone'));
        $contact->setAge($request->request->get('age'));

        $entityManager->persist($contact);
        $entityManager->flush();

        return $this->json('Created new project successfully with id ' . $contact->getId());
    }
    #------------GET Request----GET CONTACT BY ID------------------------
    /**
     * @Route("/contact/{id}", name="contact_show", methods={"GET"})
     */
    public function show(int $id): Response
    {
        $contact = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->find($id);

        if (!$contact) {

            return $this->json('No project found for id :' . $id, 404);
        }

        $data =  [
            'id' => $contact->getId(),
            'name' => $contact->getName(),
            'firstName' => $contact->getFirstName(),
            'email' => $contact->getEmail(),
            'address' => $contact->getAddress(),
            'phone' => $contact->getPhone(),
            'age' => $contact->getAge(),
        ];

        return $this->json($data);
    }
    #------------PUT Request----UPDATE A CONTACT------------------------
    /**
     * @Route("/contact/{id}", name="contact_edit", methods={"PUT"})
     */
    public function edit(Request $request, int $id): Response
    {
        $entityManager = $this->getDoctrine()->getManager();
        $contact = $entityManager->getRepository(Contact::class)->find($id);

        if (!$contact) {
            return $this->json('No project found for id :' . $id, 404);
        }
        $contact->setName($request->request->get('name'));
        $contact->setFirstName($request->request->get('firstName'));
        $contact->setEmail($request->request->get('email'));
        $contact->setAddress($request->request->get('address'));
        $contact->setPhone($request->request->get('phone'));
        $contact->setAge($request->request->get('age'));
        $entityManager->flush();

        $data =  [
            'id' => $contact->getId(),
            'name' => $contact->getName(),
            'firstName' => $contact->getFirstName(),
            'email' => $contact->getEmail(),
            'address' => $contact->getAddress(),
            'phone' => $contact->getPhone(),
            'age' => $contact->getAge(),
        ];

        return $this->json($data);
    }
}
