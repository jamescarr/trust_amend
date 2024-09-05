<x-app-layout>
    <x-slot name="title">
        Lawyer Dashboard
    </x-slot>

    <div class="container mx-auto mt-8">
        <h1 class="text-3xl font-bold mb-4">Lawyer Dashboard</h1>
        <p>Welcome, {{ Auth::user()->name }}!</p>
        <p>Here you can view your clients and their trusts.</p>
        <!-- Add list of clients and their trusts here -->
    </div>
</x-app-layout>
