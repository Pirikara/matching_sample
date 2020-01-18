<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Reaction;
use App\Constant\Status;

//Logファサードの有効化
use Log;

class ReactionController extends Controller
{
    //requestにはpostされた情報が入っている
    public function create(Request $request)
    {
        //postで渡ってきた内容をlogに抽出 laravel.logに保存される
        Log::debug($request);


        //requestをそれぞれ変数にセット
        $to_user_id = $request->to_user_id;
        $like_status = $request->reaction;
        $from_user_id = $request->from_user_id;

        //likeとdislikeを定数で設定
        if($like_status == 'like'){
            $status = Status::LIKE;
        }else{
            $status = Status::DISLIKE;
        }

        //すでにある組み合わせかどうかを判別するメソッド
        $checkReaction = Reaction::where([
            ['to_user_id', $to_user_id],
            ['from_user_id', $from_user_id]
        ])->get();

        //ない場合は新しくDBに保存する
        if($checkReaction->isEmpty()){
            $reaction = new Reaction();

            $reaction->to_user_id = $to_user_id;
            $reaction->from_user_id = $from_user_id;
            $reaction->status = $status;

            $reaction->save();
        }
    }

}
