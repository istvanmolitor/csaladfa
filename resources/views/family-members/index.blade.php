@extends('layouts.app')

@section('title', 'Családtagjaim')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <family-member-manager></family-member-manager>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @vite(['resources/js/app.js'])
@endpush
