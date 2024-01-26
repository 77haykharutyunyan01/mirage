<?php

namespace App\Http\Controllers;

use App\Services\Task\Dto\CreateTaskDto;
use App\Http\Requests\CreateTaskRequest;
use App\Services\Task\Action\CreateTaskAction;

class TaskCreateController extends Controller
{
    public function __invoke(
        CreateTaskRequest $createTaskRequest,
        CreateTaskAction $createTaskAction,
    ) {
        $dto = CreateTaskDto::fromRequest($createTaskRequest);

        $createTaskAction->run($dto);
    }
}
