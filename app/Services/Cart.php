<?php

namespace App\Services;

use App\Models\Book;
use Illuminate\Support\Collection;

class Cart
{
    protected const SESSION_KEY = 'cart';

    protected function raw(): array
    {
        return session()->get(self::SESSION_KEY, []);
    }

    protected function save(array $items): void
    {
        session()->put(self::SESSION_KEY, $items);
    }

    public function add(Book $book, int $quantity = 1): void
    {
        $items = $this->raw();
        $current = $items[$book->id] ?? 0;
        $quantity = max(1, $current + $quantity);

        $items[$book->id] = min($quantity, max(1, $book->stock));
        $this->save($items);
    }

    public function update(Book $book, int $quantity): void
    {
        $items = $this->raw();

        if ($quantity <= 0) {
            unset($items[$book->id]);
        } else {
            $items[$book->id] = min($quantity, max(1, $book->stock));
        }

        $this->save($items);
    }

    public function remove(Book $book): void
    {
        $items = $this->raw();
        unset($items[$book->id]);
        $this->save($items);
    }

    public function clear(): void
    {
        session()->forget(self::SESSION_KEY);
    }

    public function items(): Collection
    {
        $items = $this->raw();

        if (empty($items)) {
            return collect();
        }

        return Book::whereIn('id', array_keys($items))
            ->get()
            ->map(fn (Book $book) => (object) [
                'book' => $book,
                'quantity' => $items[$book->id],
                'subtotal' => (float) $book->price * $items[$book->id],
            ])
            ->values();
    }

    public function subtotal(): float
    {
        return (float) $this->items()->sum('subtotal');
    }

    public function count(): int
    {
        return (int) array_sum($this->raw());
    }

    public function isEmpty(): bool
    {
        return empty($this->raw());
    }
}
