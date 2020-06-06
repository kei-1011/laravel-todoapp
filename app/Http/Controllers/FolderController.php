<?php

namespace App\Http\Controllers;

use App\Folder;
use Illuminate\Http\Request;
use App\Http\Requests\CreateFolder;
use Illuminate\Support\Facades\Auth;

class FolderController extends Controller
{
    public function showCreateForm()
    {
        return view('folders/create');
    }

    public function create(CreateFolder $request) {

        // フォルダモデルのインスタンス生成
        $folder = new Folder();

        // タイトルに入力値を代入
        $folder->title = $request->title;

        //インスタンスの状態をデータベースに書き込み,ユーザーに紐付ける
        Auth::user()->folders()->save($folder);

        return redirect()->route('tasks.index', [
            'id'    =>  $folder->id,
        ]);
    }
}
