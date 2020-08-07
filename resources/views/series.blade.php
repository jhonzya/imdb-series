@extends('layout')

@section('container')
    <search-component class="w-full" api="{{ route('search') }}"></search-component>

    {{ $title->primaryTitle }}

    @foreach($title->episodes()->get() as $episode)
        <li>
            {{ $episode->title->primaryTitle }}
            ({{ $episode->seasonNumber }} - {{ $episode->episodeNumber }})
            {{ $episode->title->rating }}
        </li>
    @endforeach
@endsection
