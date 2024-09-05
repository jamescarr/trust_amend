<x-app-layout>
    <x-slot name="title">
        Client Dashboard
    </x-slot>

    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-4">Client Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <p>Here you can view details about your trust and make changes.</p>
        <!-- Add more client-specific content here -->
    </div>


</x-app-layout>
