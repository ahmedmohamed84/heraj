@extends('layouts.new_app')

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <h1 class="text-2xl font-bold mb-4">{{ $page->title }}</h1>
            <div>
                {!! $page->content !!}
            </div>
        </div>
    </div>
@endsection
