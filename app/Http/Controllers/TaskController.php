<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use App\Http\Requests\EditTask;
use App\Http\Requests\CreateTask;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id) {

        // 全てのフォルダデータ取得
        $folders = Folder::all();

        // 選ばれたフォルダを取得 $idと一致するフォルダ
        $current_folder = Folder::find($id);

        // 選ばれたフォルダに紐づくタスクを取得 whereはSQLのwhere区と同様
        $tasks = $current_folder->tasks()->get();

        return view('tasks/index', [
            'folders'   =>  $folders,   // テンプレートにデータを受け渡し
            'current_folder_id' =>  $current_folder->id,
            'tasks' => $tasks,
        ]);
    }

    public function showCreateForm(int $id) {

        return view('tasks/create', [
            'folder_id' => $id,
        ]);
    }

    public function create(int $id, CreateTask $request)
    {
        $current_folder = Folder::find($id);

        $task = new Task();
        $task->title = $request->title;
        $task->due_date = $request->due_date;

        $current_folder->tasks()->save($task);

        return redirect()->route('tasks.index', [
            'id' => $current_folder->id,
        ]);
    }

    /**
     * GET /folders/{id}/tasks/{task_id}/edit/
     */
    public function showEditForm(int $id, int $task_id) {

        $task = Task::find($task_id);

        // 編集画面を開いた時に、input要素に値を入れておくため、taskを受け渡す
        return view('tasks/edit', [
            'task'  =>  $task,
        ]);
    }

    public function edit(int $id, int $task_id, EditTask $request) {

        /**
         * リクエストされた ID でタスクデータを取得
         * 編集対象のタスクデータに入力値を詰めて save
         * 編集対象のタスクが属するタスク一覧画面へリダイレクト
         */
        $task = Task::find($task_id);

        $task->title = $request->title;
        $task->status = $request->status;
        $task->due_date = $request->due_date;
        $task->save();

        return redirect()->route('tasks.index', [
            'id' => $task->folder_id,
        ]);
    }
}
