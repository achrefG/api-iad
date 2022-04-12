<?php

namespace App\Controller;

use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api", name="api_")
 */
class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app_contact")
     */
    public function index(): Response
    {
        $contacts = $this->getDoctrine()
            ->getRepository(Contact::class)
            ->findAll();
        dump($contacts);
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
}
