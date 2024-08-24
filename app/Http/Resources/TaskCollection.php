<?php
// app/Http/Resources/TaskCollection.php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class TaskCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return $this->collection->map(function ($task) {
            return new TaskResource($task);
        });
    }
}
