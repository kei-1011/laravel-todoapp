<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(int $id) {

        $folders = Folder::all();   // 全てのフォルダデータ取得

        return view('tasks/index', [
            'folders'   =>  $folders,   // テンプレートにデータを受け渡し
            'current_folder_id' =>  $id,
        ]);
    }
}
