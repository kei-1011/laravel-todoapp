<?php

namespace App\Http\Controllers;

use App\Folder;
use App\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id) {

        // 全てのフォルダデータ取得
        $folders = Folder::all();

        // 選ばれたフォルダを取得 $idと一致するフォルダ
        $current_folder = Folder::find($id);

        // 選ばれたフォルダに紐づくタスクを取得 whereはSQLのwhere区と同様
        $tasks = Task::where('folder_id', $current_folder->id)->get();

        return view('tasks/index', [
            'folders'   =>  $folders,   // テンプレートにデータを受け渡し
            'current_folder_id' =>  $current_folder->id,
            'tasks' => $tasks,
        ]);
    }
}
