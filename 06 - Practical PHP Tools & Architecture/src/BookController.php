<?php
declare(strict_types=1);

namespace DevNinja\Part6;

final class BookController
{
    public function __construct(private BookService $service)
    {
    }

    public function index(mixed $query): Response
    {
        if (!is_string($query)) {
            return $this->json(400, ['error' => 'Invalid search.']);
        }
        try {
            return $this->json(200, ['books' => $this->service->search($query)]);
        } catch (\InvalidArgumentException) {
            return $this->json(400, ['error' => 'Invalid search.']);
        }
    }

    public function show(int $id): Response
    {
        $book = $this->service->find($id);
        return $book === null
            ? $this->json(404, ['error' => 'Book not found.'])
            : $this->json(200, ['book' => $book]);
    }

    private function json(int $status, array $data): Response
    {
        return new Response($status, 'application/json; charset=UTF-8', json_encode($data, JSON_THROW_ON_ERROR));
    }
}
