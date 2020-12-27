<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Author;
use App\Form\Type\AuthorType;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthorController extends AbstractFOSRestController
{
    public function create(Request $request): Response
    {
        $form = $this->container->get('form.factory')
                                ->createNamed('', AuthorType::class, new Author(), ['csrf_protection' => false])
        ;

        $form->submit($request->request->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $book = $form->getData();

            $em = $this->getDoctrine()->getManager();
            $em->persist($book);
            $em->flush();

            return $this->handleView($this->view(
                [
                    'id' => $book->getId()
                ],
                Response::HTTP_CREATED
            ));
        }

        return $this->handleView($this->view(
            $form,
            Response::HTTP_BAD_REQUEST
        ));
    }
}
