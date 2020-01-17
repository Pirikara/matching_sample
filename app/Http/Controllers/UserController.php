<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//モデルファイルの呼び出し
use App\User;

class UserController extends Controller
{
    //
    public function show($id)
    {
        //Userモデル内に指定のidがあれば取得
        $user = User::findorFail($id);
        //compactメソッドを使用してcontrollerからviewへ変数を渡す
        return view('users.show', compact('user'));
    }
}
