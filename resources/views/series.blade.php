{{ $title->primaryTitle }}

@foreach($title->episodes()->get() as $episode)
    <li>
        {{ $episode->title->primaryTitle }}
        ({{ $episode->seasonNumber }} - {{ $episode->episodeNumber }})
        {{ $episode->title->rating }}
    </li>
@endforeach
