@extends('layout')

@section('page', "{$title->primaryTitle}")
@section('description', "{$title->type} {$title->startYear} - {$title->endYear}")

@section('container')
    <div class="flex bg-gray-800 border-b border-white fixed top-0 inset-x-0 z-100 h-16 items-center">
        <div class="w-full max-w-screen-xl relative mx-auto px-6">
            <div class="flex items-center -mx-6">
                <div class="pl-6 pr-6">
                    <a href="/" class="block">
                        <div class="block">
                            <tv-icon class="inline-block"></tv-icon>
                        </div>
                    </a>
                </div>

                <div class="flex flex-grow items-center">
                    <search-component></search-component>
                </div>

                <div class="pl-6 pr-6" @@click.prevent="modal = true">
                    <info-icon class="inline-block"></info-icon>
                </div>
            </div>
        </div>
    </div>

    <div class="w-full">
        <div class="flex">
            <div class="pt-20 lg:pt-28 w-full">
                <div class="mb-6 px-6 mx-0">
                    <h1 class="text-4xl title select-none">
                        {{ $title->primaryTitle }}
                    </h1>

                    <div class="mt-0 mb-4 text-gray-500">
                        <a href="{{ $title->link }}" class="underline select-none" target="_blank">Show on IMDb</a>
                    </div>

                    <div class="mt-0 mb-4">
                        <episodes-component id="{{ $title->id }}"></episodes-component>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- modal -->
    <div v-show="modal" id="info-modal" class="fixed z-10 inset-0 overflow-y-auto hidden">
        <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
            <div class="fixed inset-0 transition-opacity" @@click="modal = false">
                <div class="absolute inset-0 bg-gray-800 opacity-75"></div>
            </div>

            <div class="inline-block border-white border-2 transform transition-all sm:max-w-lg w-full" role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                <div class="bg-gray-800 px-4 pb-5 pt-3">
                    <p class="text-right cursor-pointer" @click="modal = false">x</p>
                    <h3 class="text-lg leading-6 font-medium text-white text-left pb-5">
                        Rating
                    </h3>
                    <div class="select-none text-sm leading-5 text-center border-gray-800 text-gray-800">
                        <p class="bg-blue-400 border">
                            Excellent
                        </p>
                        <p class="bg-green-400 border">
                            Very good
                        </p>
                        <p class="bg-yellow-400 border">
                            Good
                        </p>
                        <p class="bg-orange-400 border">
                            Moderate
                        </p>
                        <p class="bg-pink-400 border">
                            Bad
                        </p>
                        <p class="bg-red-400 border">
                            Very Bad
                        </p>
                        <p class="bg-gray-400 border">
                            Not Available
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
