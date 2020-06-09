<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\EditTask;
use App\Http\Requests\CreateTask;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function index(Folder $folder) {

        // ユーザーのフォルダデータ取得
        $folders = Auth::user()->folders()->get();

        // 選ばれたフォルダを取得 $idと一致するフォルダ
        $tasks = $folder->tasks()->get();

        return view('tasks/index', [
            'folders'   =>  $folders,   // テンプレートにデータを受け渡し
            'current_folder_id' =>  $folder->id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(Folder $folder) {

        return view('tasks/create', [
            'folder_id' => $folder->id,
        ]);
    }

    public function create(Folder $folder, CreateTask $request)
    {
        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $folder->id,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/{task_id}/edit/
     */
    public function showEditForm(Folder $folder, Task $task) {

        // 編集画面を開いた時に、input要素に値を入れておくため、taskを受け渡す
        return view('tasks/edit', [
            'task'  =>  $task,
        ]);
    }

    public function edit(Folder $folder, Task $task, EditTask $request) {

        /**
         * リクエストされた ID でタスクデータを取得
         * 編集対象のタスクデータに入力値を詰めて save
         * 編集対象のタスクが属するタスク一覧画面へリダイレクト
         */
        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
