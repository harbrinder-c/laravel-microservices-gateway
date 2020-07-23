<?php

namespace App\Http\Controllers;

use App\Author;
use App\Services\AuthorService;
use App\Traits\ApiResponser;
use Illuminate\Http\Response;
use Laravel\Lumen\Http\Request;

class AuthorController extends Controller
{
    use ApiResponser;

    /**
     * The service to consume authors microservices
     * @var AuthorService
     */
    public $authorService;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(AuthorService $authService)
    {
        $this->authorService = $authService;
    }

    /**
     * Return the list of authprs
     * @return Response
     */
    public function index()
    {
        return $this->successResponse($this->authorService->obtainAuthors());
    }

    /**
     * Create new author
     * @return Response
     */
    public function store(\Illuminate\Http\Request $request)
    {
        return $this->successResponse($this->authorService->createAuthor($request->all()), Response::HTTP_CREATED);
    }

    /**
     * Obtains and show one author
     * @return Response
     */
    public function show($author)
    {
        return $this->successResponse($this->authorService->obtainAuthor($author));
    }

    /**
     * Update an existing author
     * @return Response
     */
    public function update(\Illuminate\Http\Request $request, $author)
    {
        return $this->successResponse($this->authorService->editAuthor($request->all(), $author));
    }

    /**
     * delete an author
     * @return Response
     */
    public function destroy($author)
    {
        return $this->successResponse($this->authorService->deleteAuthor($author));
    }
}
