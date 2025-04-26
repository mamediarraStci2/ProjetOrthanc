@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-100">
    <div class="bg-white rounded-lg shadow-xl overflow-hidden flex" style="width: 900px; height: 550px;">
        <!-- Partie gauche - Image -->
        <div class="w-1/2">
            <img src="{{ asset('docteur.png') }}" alt="Docteur" class="w-full h-full object-cover">
        </div>

        <!-- Partie droite - Formulaire -->
        <div class="w-1/2 p-8">
            <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Connexion</h2>
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Adresse E-mail</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input id="password" type="password" name="password" required 
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-green-500 focus:border-green-500">
                </div>

                <div class="flex items-center">
                    <input type="checkbox" id="remember" name="remember" class="h-4 w-4 text-green-600">
                    <label for="remember" class="ml-2 text-sm text-gray-700">Se souvenir de moi</label>
                </div>

                <button type="submit" class="w-full py-2 px-4 bg-green-600 text-white rounded-md hover:bg-green-700 transition duration-200 ease-in-out shadow-md">
                    Se connecter
                </button>
            </form>
        </div>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #f6f8fb 0%, #e9f1f7 100%);
    }
    .shadow-xl {
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
</style>
@endsection 