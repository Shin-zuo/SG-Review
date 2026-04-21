@extends('layouts.admin')

@section('title', 'Manage Reviewers | SG-Review')
@section('header_title', 'Reviewers')

@section('content')
    <div class="w-full max-w-7xl mx-auto">

        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8 gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Course Catalog</h2>
                <p class="text-slate-500 text-sm">Manage all your board exam reviewers here.</p>
            </div>

            <div class="flex flex-col sm:flex-row items-center gap-4 w-full md:w-auto">
                <div class="relative w-full sm:w-64">
                    <svg class="w-5 h-5 absolute left-3 top-1/2 -translate-y-1/2 text-slate-400" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="searchInput" placeholder="Search courses..."
                        class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all shadow-sm text-sm">
                </div>

                <a href="{{ route('reviewers.create') }}"
                    class="w-full sm:w-auto shrink-0 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg font-bold shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Add New Course
                </a>
            </div>
        </div>

        <div id="skeletonLoader" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @for ($i = 0; $i < 3; $i++)
                <div
                    class="bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden flex flex-col animate-pulse">
                    <div class="h-40 bg-slate-200"></div>
                    <div class="p-6 flex flex-col flex-grow space-y-4">
                        <div class="h-6 bg-slate-200 rounded w-3/4"></div>
                        <div class="space-y-2">
                            <div class="h-4 bg-slate-200 rounded w-full"></div>
                            <div class="h-4 bg-slate-200 rounded w-5/6"></div>
                        </div>
                        <div class="h-8 bg-slate-200 rounded w-1/3 mt-4"></div>
                        <div class="grid grid-cols-2 gap-3 mt-auto pt-4 border-t border-slate-100">
                            <div class="h-10 bg-slate-200 rounded-lg"></div>
                            <div class="h-10 bg-slate-200 rounded-lg"></div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        <div id="courseGrid"
            class="hidden grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 opacity-0 transition-opacity duration-700">
            @forelse($courses as $course)
                <div class="course-card bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-1 flex flex-col transition-all duration-300 relative"
                    data-title="{{ strtolower($course->title) }}" data-acronym="{{ strtolower($course->acronym) }}">

                    <div
                        class="h-40 flex items-center justify-center relative overflow-hidden {{ $course->image_path ? '' : 'bg-' . $course->bg_color }}">
                        @if ($course->image_path)
                            <img src="{{ asset('storage/' . $course->image_path) }}"
                                class="absolute inset-0 w-full h-full object-cover z-0">
                            <div class="absolute inset-0 bg-slate-900/60 z-0"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-tr from-black/40 to-transparent z-0"></div>
                        @endif

                        @if ($course->badge)
                            <div
                                class="absolute top-4 right-4 bg-blue-500 text-white text-[10px] font-bold px-3 py-1 rounded-full z-20 shadow-sm uppercase tracking-wide">
                                {{ $course->badge }}
                            </div>
                        @endif

                        <span
                            class="relative text-2xl font-black text-white tracking-widest z-10">{{ $course->acronym }}</span>
                    </div>

                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $course->title }}</h3>
                        <p class="text-slate-500 mb-6 text-sm flex-grow line-clamp-2">{{ $course->description }}</p>

                        <div class="mb-4"><span
                                class="text-2xl font-extrabold text-slate-900">₱{{ number_format($course->price, 0) }}</span>
                        </div>

                        <div class="grid grid-cols-2 gap-3 mt-auto pt-4 border-t border-slate-100">
                            <a href="{{ route('reviewers.edit', $course->id) }}"
                                class="flex items-center justify-center gap-2 px-4 py-2 bg-slate-50 hover:bg-slate-100 text-slate-700 border border-slate-200 rounded-xl font-semibold transition-colors text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                    </path>
                                </svg>
                                Edit
                            </a>

                            <form action="{{ route('reviewers.destroy', $course->id) }}" method="POST"
                                class="w-full delete-course-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    class="w-full flex items-center justify-center gap-2 px-4 py-2 bg-red-50 hover:bg-red-100 text-red-600 border border-red-100 rounded-xl font-semibold transition-colors text-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                        </path>
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div
                    class="col-span-1 sm:col-span-2 lg:col-span-3 text-center py-16 bg-white rounded-3xl border border-dashed border-slate-300">
                    <svg class="w-16 h-16 text-slate-300 mx-auto mb-4" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4">
                        </path>
                    </svg>
                    <h3 class="text-xl font-bold text-slate-700 mb-2">No courses found</h3>
                    <p class="text-slate-500 mb-6">You haven't added any reviewer courses yet.</p>
                    <a href="{{ route('reviewers.create') }}"
                        class="inline-flex bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg font-bold transition-all">Create
                        your first course</a>
                </div>
            @endforelse
        </div>
    </div>

    <script>
        // 1. Loading Animation Logic
        // We wait for all images and network requests to finish before showing the cards
        window.addEventListener('load', () => {
            const skeleton = document.getElementById('skeletonLoader');
            const grid = document.getElementById('courseGrid');

            // Add a tiny delay just so the skeleton is visible even on fast networks (for premium feel)
            setTimeout(() => {
                skeleton.classList.add('hidden');
                grid.classList.remove('hidden');
                grid.classList.add('grid');

                // Trigger the fade-in opacity
                setTimeout(() => {
                    grid.classList.remove('opacity-0');
                }, 50);
            }, 300);
        });

        // 2. Live Client-Side Search Logic
        document.addEventListener('DOMContentLoaded', () => {
            const searchInput = document.getElementById('searchInput');
            const cards = document.querySelectorAll('.course-card');

            if (searchInput) {
                searchInput.addEventListener('input', (e) => {
                    const searchTerm = e.target.value.toLowerCase();

                    cards.forEach(card => {
                        const title = card.getAttribute('data-title');
                        const acronym = card.getAttribute('data-acronym');

                        // If the typed word is in the title OR the acronym, show it. Otherwise, hide it.
                        if (title.includes(searchTerm) || acronym.includes(searchTerm)) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            }
        });


        document.querySelectorAll('.delete-course-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault(); // Stop the form from submitting immediately

                Swal.fire({
                    title: 'Are you absolutely sure?',
                    text: "This will permanently delete this course. You cannot undo this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444', // Tailwind red-500
                    cancelButtonColor: '#64748b', // Tailwind slate-500
                    confirmButtonText: 'Yes, delete it!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        popup: 'bg-white rounded-2xl shadow-xl border border-slate-200',
                        title: 'text-slate-800 font-bold',
                        htmlContainer: 'text-slate-500 text-sm'
                    }
                }).then((result) => {
                    // If they clicked the red "Yes" button, submit the form!
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
