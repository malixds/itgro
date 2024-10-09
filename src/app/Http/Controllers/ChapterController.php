<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChapterRequest;
use App\Http\Resources\CreateChapterResource;
use App\Interfaces\IChapterRepository;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    public function __construct(private IChapterRepository $repository)
    {

    }
    public function create(CreateChapterRequest $request)
    {
        $chapter = $this->repository->create($request->validated());
        return new CreateChapterResource($chapter);
    }
}
