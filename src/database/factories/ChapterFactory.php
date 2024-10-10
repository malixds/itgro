<?php

namespace Database\Factories;

use App\Models\Chapter;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChapterFactory extends Factory
{
    protected $model = Chapter::class;
    public function definition()
    {
        return [
            'book_id' => 1,
            'name' => $this->faker->name(),
            'content' => $this->faker->text(),
        ];
    }

}
