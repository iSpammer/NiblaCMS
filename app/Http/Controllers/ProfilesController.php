<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index($user)
    {
        $user = User::findOrFail($user);
        return view('profiles.index', [
            'user' => $user,
        ]);
        $follows = (auth()->user() ? auth()->user()->following->contain($user->id): false);
        $postCount = Cache::remember('count.posts.'.$user->id, now()->addSeconds(30) ,function () use ($user){
           return $user->posts->count();
        });
        $followersCount = $user->profile->followers->count();
        $followingCount = $user->following->count();
        return view('profiles.index', compact('postCount', 'user', 'follows'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);
        return view('profiles.edit', compact('user'));
    }
    public function update(User $user)
    {
        $this->authorize('update', $user->profile);
        $data = request()->validate([
            'title' => ['required'],
            'description' => ['required'],
            'url' => ['url'],
            'image' => '',
        ]);
        if (request('image')){
            $imagePath = request('image')->store('profile', 'public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
            $imageArr = ['image' => $imagePath];
        }
        //dd(array_merge($data, ['image' => $imagePath]));
        auth()->user()->profile->update(array_merge($data, $imageArr ?? []));
        return redirect('/profile/'.$user->id);
    }
}
