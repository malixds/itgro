<?php

namespace App\Services\Chapter;

use App\Interfaces\IChapterRepository;
use App\Models\Chapter;
use Illuminate\Support\Facades\DB;

class UpdateChapterService
{
    public function __construct(private IChapterRepository $repository)
    {
    }

    public function run(array $data, Chapter $chapter): ?Chapter
    {
        $diff =  iconv_strlen($data["content"]) - iconv_strlen($chapter->content);
        DB::transaction(function() use ($data, &$chapter, $diff) {
            $this->repository->update($data, $chapter->id);
            $chapter->book->total_characters += $diff;
            $chapter->book->save();
        });
        return $this->repository->find($chapter->id);
    }

}
