<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {

         $postCount = Cache::remember(
            'count.posts'. $user->id,
          now()->addSecond(30),
           function() use ($user) {
            return $user->posts->count();

         });

         $followerCount = $user->profile->followers->count() ;
         $followingCount = $user->following->count();

       $follows = (auth()->user()) ? auth()->user()->following->contains($user->id):false;

        return view('profile.index', compact('user', 'follows', 'postCount', 'followerCount', 'followingCount'));
    }

    public function edit(User $user)
    {

        // $this->authorize('update', $user->profile);

        return view('profile.edit', compact('user'));
    }
    public function update(User $user)
    {
        // $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

       if(request('image')){

        $imagePath = (request('image')->store('profile', 'public'));

        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
        $image->save();
        $imageArray =  ['image' => $imagePath];
       }
       auth()->user()->profile->update(array_merge(
           $data,
            $imageArray ?? []
    ));

       return redirect("/profile/{$user->id}");
    }
}
