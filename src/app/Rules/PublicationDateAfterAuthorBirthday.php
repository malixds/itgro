<?php

namespace App\Rules;

use App\Interfaces\IAuthorRepository;
use Carbon\Carbon;
use DateTime;
use Exception;
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
        try {
            $publicationDate = Carbon::createFromFormat('d-m-Y', $value);
            $birthday = Carbon::createFromFormat('Y-m-d', $author->birthday);
            return $publicationDate->greaterThan($birthday) && $publicationDate->lessThan(now());

        } catch (Exception){
        }
        return false;
    }
    public function message()
    {
        return 'Дата публикации должна быть позже даты рождения автора и меньше текущей даты.';
    }
}
