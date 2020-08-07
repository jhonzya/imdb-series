@extends('layout')

@section('container')
    <div class="flex h-screen items-center">
        <search-component
            class="w-full"
            api="{{ route('search') }}"
        >
        </search-component>
    </div>
@endsection
