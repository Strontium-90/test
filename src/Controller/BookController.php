<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\Type\BookSearchType;
use App\Form\Type\BookType;
use App\Repository\BookRepository;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
                $bookRepository->findByName((string) $filter['name'], 10),
                Response::HTTP_OK
            ));
        }

        return $this->handleView($this->view(
            $form,
            Response::HTTP_BAD_REQUEST
        ));
    }

    public function show(Request $request, BookRepository $bookRepository): Response
    {
        $id = $request->attributes->get('id');
        $book = $bookRepository->find($id);
        if (null === $book) {
            throw new NotFoundHttpException(sprintf('Book with id="%s" not found', $id));
        }

        return $this->handleView($this->view(
            $book,
            Response::HTTP_OK
        ));
    }
}
