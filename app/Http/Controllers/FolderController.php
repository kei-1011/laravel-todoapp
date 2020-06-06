<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    public function create(Request $request) {

        // フォルダモデルのインスタンス生成
        $folder = new Folder();

        // タイトルに入力値を代入
        $folder->title = $request->title;

        //インスタンスの状態をデータベースに書き込み
        $folder->save();

        return redirect()->route('tasks.index', [
            'id'    =>  $folder->id,
        ]);
    }
}
