<?php
/**
 * Book controller.
 */

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Service\BookService;
use DateTime;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookController.
 *
 * @Route("/book")
 */
class BookController extends AbstractController
{
    /**
     * Book service.
     *
     * @var BookService
     */
    private BookService $bookService;

    /**
     * BookController constructor.
     *
     * @param BookService $bookService Book service
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Index action.
     *
     * @param Request $request HTTP request
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="book_index",
     * )
     */
    public function index(Request $request): Response
    {
        $filters = [];
        $filters['category_id'] = $request->query->getInt('filters_category_id');
        $pagination = $this->bookService->createPaginatedList(
            $request->query->getInt('page', 1),
            $filters
        );

        return $this->render(
            'book/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Show action.
     *
     * @param Book $book Book entity
     *
     * @return Response HTTP response
     *
     * @Route(
     *     "/{id}",
     *     methods={"GET"},
     *     name="book_show",
     *     requirements={"id": "[1-9]\d*"},
     * )
     */
    public function show(Book $book): Response
    {
        return $this->render(
            'book/show.html.twig',
            ['book' => $book]
        );
    }
    /**
     * Create action.
     *
     * @param Request     $request     HTTP request
     * @param BookService $bookService Book service
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="book_create",
     * )
     */
    public function create(Request $request, BookService $bookService): Response
    {
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setCreatedAt(new DateTime());
            $book->setUpdatedAt(new DateTime());
            $bookService->save($book);
            $this->addFlash('success', 'message_created_successfully');

            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param Request     $request     HTTP request
     * @param Book        $book        Book entity
     * @param BookService $bookService Book service
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="book_edit",
     * )
     */
    public function edit(Request $request, Book $book, BookService $bookService): Response
    {
        $form = $this->createForm(BookType::class, $book, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $book->setUpdatedAt(new DateTime());
            $bookService->save($book);
            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/edit.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param Request     $request     HTTP request
     * @param Book        $book        Book entity
     * @param BookService $bookService Book service
     *
     * @return Response HTTP response
     *
     * @throws ORMException
     * @throws OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="book_delete",
     * )
     */
    public function delete(Request $request, Book $book, BookService $bookService): Response
    {
        $form = $this->createForm(FormType::class, $book, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $bookService->delete($book);
            $this->addFlash('success', 'message_deleted_successfully');

            return $this->redirectToRoute('book_index');
        }

        return $this->render(
            'book/delete.html.twig',
            [
                'form' => $form->createView(),
                'book' => $book,
            ]
        );
    }
}
