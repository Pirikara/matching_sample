<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//モデルファイルの呼び出し
use App\User;
//画像アップロードメソッドの呼び出し
use Intervention\Image\Facades\Image;
use App\Services\CheckExtensionServices;
use App\Services\FileUploadServices; 

use App\Http\Requests\ProfileRequest;

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

    public function edit($id)
    {
        $user = User::findorFail($id);
        return view('users.edit', compact('user'));
    }

    //$requestには、フォームで送信されてきた値が入っている
    public function update($id, ProfileRequest $request)
    {
        $user = User::findorFail($id);

        //写真がアップロードされていれば、ファイル名を生成して上書きする
        if(!is_null($request['img_name'])){
            $imageFile = $request['img_name'];

            $list = FileUploadServices::fileUpload($imageFile);
            list($extension, $fileNameToStore, $fileData) = $list;

            $data_url = CheckExtensionServices::checkExtension($fileData, $extension);
            $image = Image::make($data_url);        
            $image->resize(400,400)->save(storage_path() . '/app/public/images/' . $fileNameToStore );

            $user->img_name = $fileNameToStore;
        }

        //user情報の更新
        $user->name = $request->name;
        $user->email = $request->email;
        $user->sex = $request->sex;
        $user->self_introduction = $request->self_introduction;

        $user->save();

        return redirect()->to('home'); 
    }
}
