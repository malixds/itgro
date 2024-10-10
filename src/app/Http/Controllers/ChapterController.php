<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Http\Resources\Chapter\ChapterCreateResource;
use App\Http\Resources\Chapter\ChapterUpdateResource;
use App\Models\Chapter;
use App\Services\Chapter\CreateChapterService;
use App\Services\Chapter\UpdateChapterService;

class ChapterController extends Controller
{
    public function chapterCreate(CreateChapterRequest $request, CreateChapterService $service): ChapterCreateResource
    {
        return new ChapterCreateResource($service->run(null, $request->validated()));
    }

    public function chapterUpdate(UpdateChapterRequest $request, Chapter $chapter, UpdateChapterService $service)
    {
        return new ChapterUpdateResource($service->run($request->validated(), $chapter));
    }
}
