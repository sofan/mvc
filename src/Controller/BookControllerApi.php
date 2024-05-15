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
class BookControllerApi extends AbstractController
{
    /**
     * Route to genereate book api
     *
     * @param BookRepository $bookRepository
     * @return Response
     */
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



    /**
     * Route to generate api for book by ISBN
     */
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
