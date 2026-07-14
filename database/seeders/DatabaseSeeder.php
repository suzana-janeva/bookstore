<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // --- Users ---------------------------------------------------------
        $admin = User::factory()->create([
            'name' => 'Suzana Janeva',
            'email' => 'admin@suzanajaneva.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
        ]);

        $customer = User::factory()->create([
            'name' => 'Test Customer',
            'email' => 'customer@example.com',
            'password' => bcrypt('password'),
            'role' => 'customer',
        ]);

        // --- Categories ----------------------------------------------------
        $categoryNames = [
            'Fiction',
            'Non-Fiction',
            'Science & Technology',
            'Fantasy & Sci-Fi',
            'Business',
        ];

        $categories = [];
        foreach ($categoryNames as $name) {
            $categories[$name] = Category::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        // --- Books ---------------------------------------------------------
        $books = [
            ['The Midnight Library', 'Matt Haig', 'Fiction', 16.99, 24],
            ['Klara and the Sun', 'Kazuo Ishiguro', 'Fiction', 18.50, 12],
            ['Normal People', 'Sally Rooney', 'Fiction', 14.00, 30],
            ['Sapiens: A Brief History of Humankind', 'Yuval Noah Harari', 'Non-Fiction', 22.00, 18],
            ['Atomic Habits', 'James Clear', 'Non-Fiction', 19.99, 40],
            ['Educated', 'Tara Westover', 'Non-Fiction', 15.75, 9],
            ['The Pragmatic Programmer', 'Andrew Hunt & David Thomas', 'Science & Technology', 39.99, 15],
            ['Clean Code', 'Robert C. Martin', 'Science & Technology', 34.50, 7],
            ['A Brief History of Time', 'Stephen Hawking', 'Science & Technology', 17.25, 20],
            ['Project Hail Mary', 'Andy Weir', 'Fantasy & Sci-Fi', 21.00, 26],
            ['The Name of the Wind', 'Patrick Rothfuss', 'Fantasy & Sci-Fi', 18.99, 14],
            ['Dune', 'Frank Herbert', 'Fantasy & Sci-Fi', 20.00, 3],
            ['The Fifth Season', 'N. K. Jemisin', 'Fantasy & Sci-Fi', 17.99, 0],
            ['Zero to One', 'Peter Thiel', 'Business', 23.00, 22],
            ['The Lean Startup', 'Eric Ries', 'Business', 24.50, 11],
            ['Thinking, Fast and Slow', 'Daniel Kahneman', 'Business', 25.99, 16],
        ];

        $featuredTitles = [
            'The Midnight Library',
            'Atomic Habits',
            'Project Hail Mary',
            'Sapiens: A Brief History of Humankind',
        ];

        $descriptions = [
            'A captivating read that lingers long after the final page. Widely praised by critics and readers alike.',
            'An essential title that has shaped conversations and earned a permanent place on countless shelves.',
            'Beautifully written and deeply human — a story that rewards slow, thoughtful reading.',
            'Sharp, insightful, and impossible to put down. A modern classic in the making.',
        ];

        $createdBooks = [];
        foreach ($books as $i => [$title, $author, $category, $price, $stock]) {
            $createdBooks[] = Book::create([
                'title' => $title,
                'slug' => Str::slug($title),
                'author' => $author,
                'price' => $price,
                'stock' => $stock,
                'description' => $descriptions[$i % count($descriptions)]
                    . ' ' . $descriptions[($i + 1) % count($descriptions)],
                'featured' => in_array($title, $featuredTitles, true),
                'category_id' => $categories[$category]->id,
            ]);
        }

        // --- A couple of sample reviews -----------------------------------
        Review::create([
            'book_id' => $createdBooks[0]->id,
            'user_id' => $customer->id,
            'rating' => 5,
            'comment' => 'Absolutely loved this — could not put it down!',
        ]);

        Review::create([
            'book_id' => $createdBooks[4]->id,
            'user_id' => $customer->id,
            'rating' => 4,
            'comment' => 'Practical and motivating. A few chapters really stuck with me.',
        ]);
    }
}
