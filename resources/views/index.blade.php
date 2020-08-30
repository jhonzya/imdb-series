@extends('layout')

@section('page', 'Buscar serie')

@section('container')
    <div class="px-4">
        <div class="flex py-10 md:py-20 lg:py-24">
            <div class="m-auto">
                <h1 class="text-6xl title">
                    axio
                </h1>
            </div>
        </div>
        <div class="flex flex-col py-2">
            <search-component api="{{ route('search') }}">
            </search-component>
        </div>
    </div>
@endsection
