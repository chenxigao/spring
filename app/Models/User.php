<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Auth;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable {

    use HasRoles;
    use Notifiable {
        notify as protected laravelNotify;
    }

    public function notify($instance)
    {
        //如果要通知的用户是当前用户，就不必通知了
        if ($this->id == Auth::id()){
            return;
        }

        $this->increment('notification_count');
        $this->laravelNotify($instance);
        
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
            'name', 'email', 'password', 'avatar', 'introduction',
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

    public function markAsRead()
    {
        $this->notification_count = 0;
        $this->save();
        $this->unreadNotifications->markAsRead();
        
    }

    public function setPasswordAttribute($value)
    {
        //如果值得长度等于60，即认为是已经做过加密的情况
        if (strlen($value) != 60){
            //不等于60做密码加密处理
            $value = bcrypt($value);
        }

        $this->attributes['password'] = $value;
        
    }

    public function setAvatarAttribute($path)
    {
        //如果不是 http 子串开头，那就是从后台上传的，需要不全 URL
        if (! starts_with($path, 'http')){
            //拼接完整的 URL
            $path = config('app.url') . "/uploads/images/avatars/$path";
        }

        $this->attributes['avatar'] = $path;
    }

}
