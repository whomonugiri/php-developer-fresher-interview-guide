<?php
declare(strict_types=1);

namespace DevNinja\Part6;

final class BookRepository
{
    /** @return list<array{id: int, title: string}> */
    public function all(): array
    {
        // Fixed data keeps the architecture example runnable without a database.
        return [
            ['id' => 1, 'title' => 'PHP Basics'],
            ['id' => 2, 'title' => 'Secure PHP'],
            ['id' => 3, 'title' => 'PHP Objects'],
        ];
    }

    /** @return array{id: int, title: string}|null */
    public function find(int $id): ?array
    {
        foreach ($this->all() as $book) {
            if ($book['id'] === $id) {
                return $book;
            }
        }
        return null;
    }
}
