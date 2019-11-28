<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = [];

    public function profileImage()
    {
        $imagePath = ($this->image) ?  $this->image : 'profile/http://localhost:8000/storage/profile/53dVKzShKfw6XQ5zFuoahNpbd843Wt1Khmns3L5q.png';
        return '/storage/'. $imagePath;

    }

    public function user(){
     return $this->belongsTo(User::class);

    }
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }
}
