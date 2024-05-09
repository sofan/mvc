<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;

class BookController extends AbstractController
{
    #[Route('/library', name: 'library')]
    public function viewAllBooks(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }

    #[Route('/book/create', name: 'book_create_form', methods: ["GET"])]
    public function createBookGet(ManagerRegistry $doctrine): Response
    {

        return $this->render('book/create.html.twig');
    }

    #[Route('/book/create', name: 'book_create', methods: ["POST"])]
    public function createBookPost(Request $request, ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();

        $title = $request->request->get('title');
        $author = $request->request->get('author');
        $isbn = $request->request->get('isbn');
        $image = $request->request->get('image');

        // Create a new book object
        $book = new Book();
        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);
        $book->setImage($image);

        // Persist the book object
        $entityManager->persist($book);

        // Flush changes to the database
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Bok tillagd!'
        );

        // Redirect to a success page or do whatever you need after creating the book
        return $this->redirectToRoute('library');
    }


    #[Route('/book/update/{id}', name: 'book_update_form', methods: ["GET"])]
    public function updateBookGet(BookRepository $bookRepository, int $id): Response
    {

        $book = $bookRepository->find($id);

        $data = [
            'book' => $book
        ];

        return $this->render('book/update.html.twig', $data);
    }

    #[Route('/book/update/{id}', name: 'book_update', methods: ["POST"])]
    public function updateBook(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        $title = $request->request->get('title');
        $author = $request->request->get('author');
        $isbn = $request->request->get('isbn');
        $image = $request->request->get('image');

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $book->setTitle($title);
        $book->setAuthor($author);
        $book->setIsbn($isbn);
        $book->setImage($image);

        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Boken ' . $title . ' är uppdaterad!'
        );

        return $this->redirectToRoute('library');
    }





    #[Route('/book/create_', name: 'book_create_')]
    public function createBook1(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();

        $book = new Book();
        $book->setTitle('Title_' . rand(1, 9));
        $book->setAuthor('Author' . rand(1, 9));
        $book->setIsbn(rand(100, 999));
        $book->setImage('en bildlänk');

        // tell Doctrine you want to (eventually) save the Product
        // (no queries yet)
        $entityManager->persist($book);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return new Response('Saved new book with id '.$book->getId());
    }






    #[Route('/book/show/{id}', name: 'book_by_id')]
    public function viewBookById(BookRepository $bookRepository, int $id): Response
    {
        $book = $bookRepository->find($id);

        $books = $book ? [$book] : [];

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }


    #[Route('/book/delete/{id}', name: 'book_delete_by_id')]
    public function deleteProductById(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);
        $name = $book->getTitle();

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id '.$id
            );
        }

        $entityManager->remove($book);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Bok ' . $name . ' borttagen!'
        );

        return $this->redirectToRoute('library');
    }



    #[Route('/api/library/books', name: 'api_books')]
    public function showBooksApi(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        $data = ['books' => $books];

        $response = $this->json($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }


    #[Route('/api/library/book/{isbn}', name: 'api_book_by_isbn')]
    public function showBooksByISBNApi(BookRepository $bookRepository, string $isbn): Response
    {

        $book = $bookRepository->findOneBy(['isbn' => $isbn]);

        $response = $this->json($book);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
