@extends('layouts.app')

@section('content')
<div class="container">
    @foreach ($posts as $post)
        <div class="row py-4">
            <div class="col-6">
            <a href="/profile/{{ $post->user->id }} "><img src="/storage/{{ $post->image }}" alt="" class="w-100"></a>
            </div>
            <div class="col-6">
                <div>
                    <div class="d-flex pb-4 align-items-center">
                        <div class="pr-3">
                            <img src="{{ $post->user->profile->profileImage() }}" alt="" class="w-100 rounded-circle" style="max-width:40px">
                        </div>
                        <div>
                            <div class="font-weight-bold"><a href="/profile/{{ $post->user->id }}"> <span class="text-dark" >{{ $post->user->username }}</span> </a> ●</div>
                        </div>
                        <a class="pl-3" href="#">Follow</a>
                    </div>
                    <hr>
                    <p> <span class="font-weight-bold"><a href="/profile/{{ $post->user->id }}"> <span class="text-dark" >{{ $post->user->username }}</span> </a></spam> : {{ $post->caption }}</p>
                </div>
            </div>
        </div>
        <hr>
    @endforeach
    <div class="row">
        <div class="col-12 d-flex justify-content-center">
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection
