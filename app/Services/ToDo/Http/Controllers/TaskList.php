<?php

namespace App\Services\ToDo\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Services\ToDo\Models\TaskList as TaskListModel;

class TaskList extends BaseController
{
    public function index()
    {
        $lists = TaskListModel::where('user_id', auth()->id())->get();

        $this->setViewData(compact('lists'));

        return $this->view();
    }

    public function show($id)
    {
        $list = TaskListModel::find($id);

        if ($list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnList();
        }

        $this->setViewData(compact('list'));

        return $this->view();
    }

    public function create()
    {
        return $this->view();
    }

    public function store()
    {
        try {
            TaskListModel::create(request()->all());
        } catch (\Exception $exception) {
            return redirect()
                ->route('task-list.index')
                ->with('error', 'Could not create task list: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task-list.index')
            ->with('message', 'Your task list has been added.');
    }

    public function edit($id)
    {
        $list = TaskListModel::find($id);

        if ($list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnList();
        }

        $this->setViewData(compact('list'));

        return $this->view();
    }

    public function update($id)
    {
        try {
            TaskListModel::find($id)
                ->update(request()->all());
        } catch (\Exception $exception) {
            return redirect()
                ->route('task-list.index')
                ->with('error', 'Could not update task list: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task-list.index')
            ->with('message', 'Your task list has been updated.');
    }

    public function delete($id)
    {
        $list = TaskListModel::find($id);

        if ($list->user_id !== auth()->id()) {
            return $this->redirectWhenUserDoesNotOwnList();
        }

        try {
            $list->delete();
        } catch (\Exception $exception) {
            return redirect()
                ->route('task-list.index')
                ->with('error', 'Could not delete task list: ' . $exception->getMessage());
        }

        return redirect()
            ->route('task-list.index')
            ->with('message', 'Your task list has been removed.');
    }

    /**
     * If the list does not belong to the user that requested
     * the page, redirect them to their list with an error.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectWhenUserDoesNotOwnList()
    {
        return redirect()
            ->route('task-list.index')
            ->with('error', 'You do not own this list.');
    }
}
