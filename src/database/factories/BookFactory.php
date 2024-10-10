<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{

    protected $model = Book::class;

    public function definition(): array
    {
        return [
            'author_id' => 1,
            'name' => $this->faker->name(),
            'annotation' => $this->faker->text(300),
            'published_at' => $this->faker->date(),
        ];
    }

}
