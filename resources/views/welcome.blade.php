@extends('layouts.app')

@section('title', 'Kezdőlap')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 text-gray-900">
                <h1 class="text-3xl font-bold mb-4">Üdvözöljük a Családfa Szerkesztőben!</h1>
                <p class="mb-6 text-lg text-gray-600">
                    Ez az oldal segít Önnek feltérképezni és megőrizni családi örökségét.
                    Kezdjen el kutatni vagy szerkeszteni saját családfáját.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                    <div class="border rounded-lg p-6 hover:bg-gray-50 transition duration-150">
                        <h2 class="text-xl font-semibold mb-2">Családfa Szerkesztő</h2>
                        <p class="text-gray-600 mb-4">Adja hozzá családtagjait, kapcsolatait és építse fel vizuálisan a családfáját.</p>
                        <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            Szerkesztés indítása &rarr;
                        </a>
                    </div>

                    <div class="border rounded-lg p-6 hover:bg-gray-50 transition duration-150">
                        <h2 class="text-xl font-semibold mb-2">Családfa Kutató</h2>
                        <p class="text-gray-600 mb-4">Keressen ősei között, böngésszen a meglévő adatokban és fedezzen fel új kapcsolatokat.</p>
                        <a href="#" class="inline-flex items-center text-blue-600 hover:text-blue-800 font-medium">
                            Kutatás indítása &rarr;
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
