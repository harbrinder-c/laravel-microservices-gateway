<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;

class BookController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume books microservices
     * @var BookService
     */
    public $bookService;


    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Return the list of books
     * @return Response
     */
    public function index()
    {
        return $this->successResponse($this->bookService->obtainBooks());
    }

    /**
     * Create new book
     * @return Response
     */
    public function store(\Illuminate\Http\Request $request)
    {
        return $this->successResponse($this->bookService->createBook($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one book
     * @return Response
     */
    public function show($book)
    {
        return $this->successResponse($this->bookService->obtainBook($book));
    }

    /**
     * Update an existing book
     * @return Response
     */
    public function update(\Illuminate\Http\Request $request, $book)
    {
        return $this->successResponse($this->bookService->editBook($request->all(), $book));
    }

    /**
     * delete an book
     * @return Response
     */
    public function destroy($book)
    {
        return $this->successResponse($this->bookService->deleteBook($book));
    }
}
