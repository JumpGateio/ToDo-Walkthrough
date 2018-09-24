<?php

namespace App\Services\ToDo\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\ToDo\Models\Task as TaskModel;
use App\Services\ToDo\Models\TaskList;

class Task extends BaseController
{
    public function show($id)
    {
        $task = TaskModel::with('list')
            ->find($id);

        if ($task->list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnTask();
        }

        $this->setViewData(compact('task'));

        return $this->view();
    }

    public function create($listId)
    {
        $lists = TaskList::orderByNameAsc()
            ->get()
            ->pluck('name', 'slug');

        $this->setViewData(compact('lists', 'listId'));

        return $this->view();
    }

    public function store($listId)
    {
        try {
            TaskModel::create(request()->all());
        } catch (\Exception $exception) {
            return redirect()
                ->route('task.index')
                ->with('error', 'Could not create task: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task.index')
            ->with('message', 'Your task has been added.');
    }

    public function edit($id)
    {
        $task = TaskModel::with('list')
            ->find($id);

        if ($task->list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnTask();
        }

        $lists = TaskList::orderByNameAsc()
            ->get()
            ->pluck('name', 'slug');

        $this->setViewData(compact('task', 'lists'));

        return $this->view();
    }

    public function update($id)
    {
        try {
            TaskModel::find($id)
                ->update(request()->all());
        } catch (\Exception $exception) {
            return redirect()
                ->route('task.index')
                ->with('error', 'Could not update task: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task.index')
            ->with('message', 'Your task has been updated.');
    }

    public function delete($id)
    {
        $task = TaskModel::with('list')
            ->find($id);

        if ($task->list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnTask();
        }

        try {
            $task->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->route('task.index')
                ->with('error', 'Could not delete task: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task.index')
            ->with('message', 'Your task has been removed.');
    }

    /**
     * If the list does not belong to the user that requested
     * the page, redirect them to their list with an error.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectWhenUserDoesNotOwnTask()
    {
        return redirect()
            ->route('task.index')
            ->with('error', 'You do not own this task.');
    }
}
