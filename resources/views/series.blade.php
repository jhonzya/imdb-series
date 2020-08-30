@extends('layout')

@section('page', "{$title->primaryTitle} (TV Series {$title->startYear} - {$title->endYear})")

@section('container')
    <div class="flex bg-gray-800 border-b border-white fixed top-0 inset-x-0 z-100 h-16 items-center">
        <div class="w-full max-w-screen-xl relative mx-auto px-6">

            <div class="flex items-center -mx-6">
                <div class="pl-6 pr-6">
                    <a href="/" class="block">
                        <div class="hidden md:block text-3xl">
                            axio
                        </div>

                        <div class="block md:hidden">
                            <tv-icon class="inline-block"></tv-icon>
                        </div>
                    </a>
                </div>

                <div class="flex flex-grow pr-6 items-center">
                    <search-component
                        api="{{ route('search') }}">
                    </search-component>
                </div>
            </div>
        </div>
    </div>

    <div class="min-h-screen w-full">
        <div class="flex">
            <div class="pt-20 pb-16 lg:pt-28 w-full">
                <div class="mb-6 px-6 mx-0">
                    <h1 class="text-4xl title select-none">
                        {{ $title->primaryTitle }}
                    </h1>

                    <div class="mt-0 mb-4 text-gray-500">
                        <a href="{{ $title->link }}" class="underline select-none" target="_blank">Ver en IMDb</a>
                    </div>

                    <div class="mt-0 mb-4">
                        <episodes-component api="{{ $title->api }}"></episodes-component>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
