<?php

namespace App\Controller;

use App\Entity\Book;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\SerializerInterface;

class BookController extends AbstractController
{
    // GET /books - list all books
    #[Route('/books', methods: ['GET'])]
    public function getBooks(EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $books = $em->getRepository(Book::class)->findAll();
        $json = $serializer->serialize($books, 'json');
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }

    // GET /books/{id} - get book by ID
    #[Route('/books/{id}', methods: ['GET'])]
    public function getBook($id, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) {
            return new Response(json_encode(['error' => 'Book not found']), 404, ['Content-Type' => 'application/json']);
        }

        $json = $serializer->serialize($book, 'json');
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }

    // POST /books - create a new book
    #[Route('/books', methods: ['POST'])]
    public function createBook(Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $data = json_decode($request->getContent(), true);

        $book = new Book();
        $book->setTitle($data['title'] ?? '');
        $book->setAuthor($data['author'] ?? '');
        $book->setYear($data['year'] ?? 0);
        $book->setPrice($data['price'] ?? 0.0);

        $em->persist($book);
        $em->flush();

        $json = $serializer->serialize($book, 'json');
        return new Response($json, 201, ['Content-Type' => 'application/json']);
    }

    // PUT /books/{id} - update book
    #[Route('/books/{id}', methods: ['PUT'])]
    public function updateBook($id, Request $request, EntityManagerInterface $em, SerializerInterface $serializer): Response
    {
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) {
            return new Response(json_encode(['error' => 'Book not found']), 404, ['Content-Type' => 'application/json']);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['title'])) $book->setTitle($data['title']);
        if (isset($data['author'])) $book->setAuthor($data['author']);
        if (isset($data['year'])) $book->setYear($data['year']);
        if (isset($data['price'])) $book->setPrice($data['price']);

        $em->flush();

        $json = $serializer->serialize($book, 'json');
        return new Response($json, 200, ['Content-Type' => 'application/json']);
    }

    // DELETE /books/{id} - delete book
    #[Route('/books/{id}', methods: ['DELETE'])]
    public function deleteBook($id, EntityManagerInterface $em): Response
    {
        $book = $em->getRepository(Book::class)->find($id);

        if (!$book) {
            return new Response(json_encode(['error' => 'Book not found']), 404, ['Content-Type' => 'application/json']);
        }

        $em->remove($book);
        $em->flush();

        return new Response(null, 204);
    }
}
