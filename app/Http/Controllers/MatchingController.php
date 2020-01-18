<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Reaction;
use Auth;

use App\Constant\Status;

class MatchingController extends Controller
{
    //
    public static function index(){
        //likeしてくれた人のid情報のみ取得する
        $got_reaction_ids = Reaction::where([
            ['to_user_id', Auth::id()],
            ['status', Status::LIKE]
        ])->pluck('from_user_id');

        //likeしてくれた人の中から、自分がlikeした人だけを抽出する
        $matching_ids = Reaction::whereIn('to_user_id', $got_reaction_ids)
        ->where('status', Status::LIKE)
        ->where('from_user_id', Auth::id())
        ->pluck('to_user_id');

        $matching_users = User::whereIn('id', $matching_ids)->get();

        $match_users_count = count($matching_users);

        return view('users.index', compact('matching_users', 'match_users_count'));
    }
}
