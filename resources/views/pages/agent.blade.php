@extends('layouts.admin')

@section('title', 'Manage Agents | SG-Review')
@section('header_title', 'Agents Management')

@section('content')
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-semibold text-gray-800">Agents</h2>
            <a href=""
                class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Add New Agent</a>
        </div>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 rounded-lg shadow-sm">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Name</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Email</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Phone Number</th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-700">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($agents as $agent)
                        <tr class="border-t">
                            <td class="px-6 py-4">{{ $agent->name }}</td>
                            <td class="px-6 py-4">{{ $agent->email }}</td>
                            <td class="px-6 py-4">{{ $agent->phone_number }}</td>
                            <td class="px-6 py-4 flex space-x-2">
                                <a href="{{ route('agents.edit', $agent->id) }}"
                                    class="text-blue-500 hover:text-blue-700">Edit</a>
                                <form action="{{ route('agents.destroy', $agent->id) }}" method="POST"
                                    onsubmit="return confirm('Are you sure you want to delete this agent?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
