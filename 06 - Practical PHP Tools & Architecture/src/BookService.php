<?php
declare(strict_types=1);

namespace DevNinja\Part6;

final class BookService
{
    public function __construct(private BookRepository $repository)
    {
    }

    /** @return list<array{id: int, title: string}> */
    public function search(string $term): array
    {
        $term = trim($term);
        if (strlen($term) > 50) {
            throw new \InvalidArgumentException('Search is too long.');
        }
        return array_values(array_filter(
            $this->repository->all(),
            static fn (array $book): bool => $term === '' || stripos($book['title'], $term) !== false
        ));
    }

    /** @return array{id: int, title: string}|null */
    public function find(int $id): ?array
    {
        return $this->repository->find($id);
    }
}
