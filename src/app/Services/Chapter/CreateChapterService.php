<?php

namespace App\Services\Chapter;

use App\Interfaces\IChapterRepository;
use App\Models\Chapter;
use Illuminate\Support\Facades\DB;

class CreateChapterService
{
    public function __construct(private IChapterRepository $repository)
    {
    }
    public function run($chapter, array $data): Chapter
    {
        DB::transaction(function() use ($data, &$chapter) {
            $chapter = $this->repository->create($data);
            $chapter->book->total_characters += iconv_strlen($chapter->content);
            $chapter->book->save();
        });
        return $chapter;
    }

}
