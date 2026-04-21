@extends('layouts.admin')

@section('title', 'Add New Course | SG-Review')
@section('header_title', 'Add New Course')

@section('content')
<div class="max-w-4xl mx-auto">
    
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('reviewers') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-200 transition-colors shadow-sm">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h2 class="text-2xl font-bold text-slate-800">Create Reviewer</h2>
            <p class="text-slate-500 text-sm">Add a new board exam course to your catalog.</p>
        </div>
    </div>

    @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-200 text-red-600 text-sm">
            <ul class="list-disc list-inside font-medium">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reviewers.store') }}" method="POST" enctype="multipart/form-data" class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
        @csrf
        
        <div class="p-6 md:p-8 space-y-6">
            
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-2">
                    <label for="title" class="block text-sm font-bold text-slate-700">Course Title <span class="text-red-500">*</span></label>
                    <input type="text" id="title" name="title" required value="{{ old('title') }}" placeholder="e.g., Civil Engineering" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label for="acronym" class="block text-sm font-bold text-slate-700">Acronym <span class="text-red-500">*</span></label>
                    <input type="text" id="acronym" name="acronym" required value="{{ old('acronym') }}" placeholder="e.g., CELE" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="space-y-2">
                <label for="description" class="block text-sm font-bold text-slate-700">Description <span class="text-red-500">*</span></label>
                <textarea id="description" name="description" rows="3" required placeholder="Master Mathematics, Surveying..." class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all resize-none">{{ old('description') }}</textarea>
            </div>

            <div class="grid md:grid-cols-2 gap-6 border-t border-slate-100 pt-6">
                <div class="space-y-2">
                    <label for="price" class="block text-sm font-bold text-slate-700">Price (₱) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" id="price" name="price" required value="{{ old('price') }}" placeholder="5000.00" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label for="enrollment_link" class="block text-sm font-bold text-slate-700">Enrollment Link <span class="text-red-500">*</span></label>
                    <input type="url" id="enrollment_link" name="enrollment_link" required value="{{ old('enrollment_link') }}" placeholder="https://tinyurl.com/..." class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>
            </div>

            <div class="grid md:grid-cols-3 gap-6 border-t border-slate-100 pt-6">
                <div class="space-y-3">
                    <label class="block text-sm font-bold text-slate-700">Card Theme Color</label>
                    <div class="flex flex-wrap items-center gap-3">
                        @php
                            $colors = [
                                'slate-800' => 'bg-slate-800',
                                'blue-600' => 'bg-blue-600',
                                'cyan-500' => 'bg-cyan-500',
                                'emerald-600' => 'bg-emerald-600',
                                'purple-600' => 'bg-purple-600',
                                'rose-600' => 'bg-rose-600',
                            ];
                            $selectedColor = old('bg_color', 'blue-600');
                        @endphp

                        @foreach($colors as $value => $bgClass)
                        <label class="cursor-pointer group relative">
                            <input type="radio" name="bg_color" value="{{ $value }}" class="peer sr-only" {{ $selectedColor === $value ? 'checked' : '' }}>
                            <div class="w-9 h-9 rounded-full {{ $bgClass }} ring-2 ring-offset-2 ring-transparent peer-checked:ring-slate-400 hover:scale-110 transition-all shadow-sm border border-black/10"></div>
                        </label>
                        @endforeach
                    </div>
                    <p class="text-xs text-slate-500">Select a base color. This will be ignored if you upload a cover image.</p>
                </div>

                <div class="space-y-2">
                    <label for="badge" class="block text-sm font-bold text-slate-700">Badge (Optional)</label>
                    <input type="text" id="badge" name="badge" value="{{ old('badge') }}" placeholder="e.g., Most Popular" class="w-full px-4 py-2.5 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all">
                </div>

                <div class="space-y-2">
                    <label for="image" class="block text-sm font-bold text-slate-700">Cover Image (Optional)</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full px-4 py-2 rounded-lg border border-slate-300 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 text-sm text-slate-600 transition-all">
                </div>
            </div>

        </div>

        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200 flex justify-end gap-3">
            <a href="{{ route('reviewers') }}" class="px-6 py-2.5 rounded-lg text-slate-600 font-bold hover:bg-slate-200 transition-colors">Cancel</a>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-2.5 rounded-lg font-bold shadow-md hover:shadow-lg transition-all">
                Save Course
            </button>
        </div>
    </form>
</div>
@endsection