<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateChapterRequest;
use App\Http\Requests\UpdateChapterRequest;
use App\Http\Resources\CreateChapterResource;
use App\Http\Resources\UpdateChapterResource;
use App\Interfaces\IChapterRepository;
use App\Models\Chapter;
use App\Services\Chapter\CreateChapterService;
use App\Services\Chapter\UpdateChapterService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChapterController extends Controller
{
    public function chapterCreate(CreateChapterRequest $request, CreateChapterService $service): CreateChapterResource
    {
        return new CreateChapterResource($service->run(null, $request->validated()));
    }

    public function chapterUpdate(UpdateChapterRequest $request, Chapter $chapter, UpdateChapterService $service)
    {
        return new UpdateChapterResource($service->run($request->validated(), $chapter));
    }
}
