<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\Type\BookSearchType;
use App\Form\Type\BookType;
use App\Repository\BookRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class BookController extends AbstractFOSRestController
{
    public function create(Request $request): Response
    {
        $form = $this->container->get('form.factory')
                                ->createNamed('', BookType::class, new Book(), ['csrf_protection' => false])
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

    public function search(Request $request, BookRepository $bookRepository): Response
    {
        $form = $this->container->get('form.factory')
                                ->createNamed('', BookSearchType::class, null, ['csrf_protection' => false])
        ;

        $form->submit($request->query->all());
        if ($form->isSubmitted() && $form->isValid()) {
            $filter = $form->getData();

            return $this->handleView($this->view(
                $bookRepository->search((string)$filter['name']),
                Response::HTTP_OK
            ));
        }

        return $this->handleView($this->view(
            $form,
            Response::HTTP_BAD_REQUEST
        ));
    }
}
