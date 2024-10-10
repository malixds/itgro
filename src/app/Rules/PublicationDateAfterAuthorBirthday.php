<?php

namespace App\Rules;

use App\Interfaces\IAuthorRepository;
use Carbon\Carbon;
use DateTime;
use Illuminate\Contracts\Validation\Rule;
use App\Models\Author;

class PublicationDateAfterAuthorBirthday implements Rule
{
    public function __construct(private $authorId)
    {
    }

    public function passes($attribute, $value): bool
    {
        $author = Author::query()->find($this->authorId);
        if (!$author) {
            return false; // Если автор не найден, валидация не проходит
        }

        // Преобразуем даты
        $publicationDate = Carbon::createFromFormat('d-m-Y', $value); // Используем $value вместо $this->publishedAt
        $birthday = Carbon::createFromFormat('Y-m-d', $author->birthday);

        // Проверяем, что дата публикации больше даты рождения и меньше текущей даты
        return $publicationDate->greaterThan($birthday) && $publicationDate->lessThan(now());
    }

    public function message()
    {
        return 'Дата публикации должна быть позже даты рождения автора и меньше текущей даты.';
    }
}
