<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reaction extends Model
{
    //不要なカラム情報の削除
    public $incrementing = false;
    public $timestamps = false;

    public function toUserId()
    {
        //belongsTo('相手のモデル名', '自分のモデルのID', '相手のモデルのID')で関連付け
        return $this->belongsTo('App\User', 'to_user_id', 'id');
    }

    public function toUserId()
    {
        return $this->belongsTo('App\User', 'from_user_id', 'id')
    }
}
