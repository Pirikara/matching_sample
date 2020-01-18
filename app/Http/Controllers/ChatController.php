<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ChatRoom;
use App\ChatRoomUser;
use App\ChatMessage;
use App\User;

use App\Events\ChatPusher;

use Auth;

class ChatController extends Controller
{
    //
    public static function show(Request $request){
        $matching_user_id = $request->user_id;

        //自分の持っているチャットルームを取得
        $current_user_chat_rooms = ChatRoomUser::where('user_id', Auth::id())
        ->pluck('chat_room_id');
        
        //自分の持っているチャットルームから相手のいるチャットルームを取得
        $chat_room_id = ChatRoomUser::whereIn('chat_room_id', $current_user_chat_rooms)
        ->where('user_id', $matching_user_id)
        ->pluck('chat_room_id');
            
        // なければ作成する
        if ($chat_room_id->isEmpty()){

            //チャットルームを作成
            ChatRoom::create();
            //最新チャットルームを取得
            $latest_chat_room = ChatRoom::orderBy('created_at', 'desc')->first();

            $chat_room_id = $latest_chat_room->id;

            // 新規登録 モデル側 $fillableで許可したフィールドを指定して保存
            ChatRoomUser::create( 
            ['chat_room_id' => $chat_room_id,
            'user_id' => Auth::id()]);

            ChatRoomUser::create(
            ['chat_room_id' => $chat_room_id,
            'user_id' => $matching_user_id]);
        }

        //オブジェクト型を数値型に変換
        if(is_object($chat_room_id)){
            $chat_room_id = $chat_room_id->first();
        }


        //Ajax通信用の変数
        // チャット相手のユーザー情報を取得
        $chat_room_user = User::findOrFail($matching_user_id);

        // チャット相手のユーザー名を取得(JS用)
        $chat_room_user_name = $chat_room_user->name;

        $chat_messages = ChatMessage::where('chat_room_id', $chat_room_id)
        ->orderby('created_at')
        ->get();

        return view('chat.show', compact('chat_room_id',
                                         'chat_room_user',
                                         'chat_messages',
                                         'chat_room_user_name'));

    }
}
