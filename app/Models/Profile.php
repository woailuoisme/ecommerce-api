<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    //
    protected $table = 'profile';
//    protected $fillable=[
//        'file_name','user_id','gender','birthday','mobile_phone','qq','wechat','Hobby','descriptions'
//    ];
    protected $guarded = [];

    protected $dates = ['birthday'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public const rules = [
        'name'          => 'required|alpha|min:2|max:255',
        'surname'       => 'required|alpha|min:2|max:255',
        'id_number'     => 'required|unique:members,id_number|digits:13',
        'mobile_number' => 'required|digits:10',
        'email'         => 'required|email',
        'date_of_birth' => 'nullable|date_format:Y-m-d|before:today',
    ];
}
