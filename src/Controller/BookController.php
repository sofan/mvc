<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

use App\Entity\Book;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\BookRepository;

/**
 * BookController class
 */
class BookController extends AbstractController
{
    /**
     * Route to show library
     *
     * @param BookRepository $bookRepository
     * @return Response
     */
    #[Route('/library', name: 'library')]
    public function viewAllBooks(BookRepository $bookRepository): Response
    {
        $books = $bookRepository->findAll();

        $data = [
            'books' => $books
        ];

        return $this->render('book/view.html.twig', $data);
    }


    /**
     * Route to show form to create new book
     *
     * @return Response
     */
    #[Route('/book/create', name: 'book_create_form', methods: ["GET"])]
    public function createBookGet(): Response
    {

        return $this->render('book/create.html.twig');
    }


    /**
     * Route to create new book
     *
     * @param Request $request
     * @param ManagerRegistry $doctrine
     * @return Response
     */
    #[Route('/book/create', name: 'book_create', methods: ["POST"])]
    public function createBookPost(Request $request, ManagerRegistry $doctrine): Response
    {

        $entityManager = $doctrine->getManager();

        $title = strval($request->request->get('title'));
        $author = strval($request->request->get('author'));
        $isbn = strval($request->request->get('isbn'));
        $image = strval($request->request->get('image'));

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


    /**
     * Route to show update form
     */
    #[Route('/book/update/{id}', name: 'book_update_form', methods: ["GET"])]
    public function updateBookGet(Book $book): Response
    {
        $data = [
            'book' => $book
        ];

        return $this->render('book/update.html.twig', $data);
    }


    /**
     * Route to update book
     */
    #[Route('/book/update/{id}', name: 'book_update', methods: ["POST"])]
    public function updateBook(Request $request, ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();

        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id'
            );
        }

        $title = strval($request->request->get('title'));
        $author = strval($request->request->get('author'));
        $isbn = strval($request->request->get('isbn'));
        $image = strval($request->request->get('image'));

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


    /**
     * Route to show book by ID
     */
    #[Route('/book/show/{id}', name: 'book_by_id')]
    public function viewBookById(Book $book): Response
    {

        $data = [
            'books' => [$book]
        ];

        return $this->render('book/view.html.twig', $data);
    }



    /**
     * Route to delete book by ID
     */
    #[Route('/book/delete/{id}', name: 'book_delete_by_id')]
    public function deleteProductById(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $book = $entityManager->getRepository(Book::class)->find($id);

        if (!$book) {
            throw $this->createNotFoundException(
                'No book found for id'
            );
        }

        $entityManager = $doctrine->getManager();

        $entityManager->remove($book);
        $entityManager->flush();

        $this->addFlash(
            'notice',
            'Bok ' . $book->getTitle() . ' borttagen!'
        );

        return $this->redirectToRoute('library');
    }

}
