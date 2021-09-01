@extends('layout')

@section('page', 'Search serie')

@section('container')
    <div class="w-full">
        <div class="px-6 mx-0">
            <div class="flex py-10 md:py-20 lg:py-24">
                <div class="m-auto">
                    <h1 class="text-6xl font-extrabold">
                        {{ config('app.name') }}
                    </h1>
                </div>
            </div>
            <div class="flex flex-col py-2">
                <search-component></search-component>
            </div>
        </div>
    </div>
@endsection
