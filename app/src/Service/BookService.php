<?php
 /**
  * Book service
  */

 namespace App\Service;

 use App\Entity\Book;
 use App\Repository\BookRepository;
 use Knp\Component\Pager\Pagination\PaginationInterface;
 use Knp\Component\Pager\PaginatorInterface;
 use Symfony\Component\Security\Core\User\UserInterface;

 /**
  *  Class Bookservice
  */

class BookService
{
    /**
     * Book repository
     * @var BookRepository
     */
    private $bookRepository;
    /**
     * Paginator
     * @var PaginatorInterface
     */
    private $paginator;
    /**
     * Category service.
     *
     * @var \App\Service\CategoryService
     */
    private $categoryService;
    /**
     * BookService constructor.
     *
     * @param \App\Repository\BookRepository          $bookRepository  Book repository
     * @param \Knp\Component\Pager\PaginatorInterface $paginator       Paginator
     * @param \App\Service\CategoryService            $categoryService Category service
     */
    public function __construct(BookRepository $bookRepository, PaginatorInterface $paginator, CategoryService $categoryService)
    {
        $this->bookRepository = $bookRepository;
        $this->paginator = $paginator;
        $this->categoryService = $categoryService;
    }
    /**
     * Create paginated list.
     *
     * @param int   $page
     * @param array $filters
     *
     * @return \Knp\Component\Pager\Pagination\PaginationInterface
     */
    public function createPaginatedList(int $page, array $filters = []): PaginationInterface
    {
        $filters = $this->prepareFilters($filters);

        return $this->paginator->paginate(
            $this->bookRepository->queryAll($filters),
            $page,
            BookRepository::PAGINATOR_ITEMS_PER_PAGE
        );
    }
    /**
     * Save book.
     *
     * @param Book $book Book entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function save(Book $book): void
    {
        $this->bookRepository->save($book);
    }

    /**
     * Delete book.
     *
     * @param Book $book Book entity
     *
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function delete(Book $book): void
    {
        $this->bookRepository->delete($book);
    }
    /**
     * Prepare filters for the books list.
     *
     * @param array $filters Raw filters from request
     *
     * @return array Result array of filters
     */
    private function prepareFilters(array $filters): array
    {
        $resultFilters = [];
        if (isset($filters['category_id']) && is_numeric($filters['category_id'])) {
            $category = $this->categoryService->findOneById(
                $filters['category_id']
            );
            if (null !== $category) {
                $resultFilters['category'] = $category;
            }
        }


        return $resultFilters;
    }
}
