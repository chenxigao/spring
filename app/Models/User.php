<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'introduction'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function topics()
    {
        //一个用户可以创建多个话题
        return $this->hasMany(Topic::class);

    }

    public function replies()
    {
        //一个用户可以拥有多个回复
        return $this->hasMany(Reply::class);
    }


    public function isAuthorOf($model)
    {
        //权限代码重构
        return $this->id == $model->user_id;
        
    }


}
