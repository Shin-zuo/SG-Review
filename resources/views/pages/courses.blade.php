@extends('layouts.app')

@section('title', 'All Courses & Reviewers | SG-Review')

@section('content')

{{-- =====================================================
     COURSE GRID WITH INTEGRATED SEARCH & FILTERS
     ===================================================== --}}
<!-- Added pb-24 md:pb-32 and border-b to create a clean gap before the footer -->
<section id="reviewers" class="pt-32 pb-24 md:pt-40 md:pb-32 bg-slate-50 relative min-h-screen border-b border-slate-200/60">
    <div class="container mx-auto px-6 max-w-7xl">

        {{-- Centered Heading row (Matching contact.blade.php) --}}
        <div class="reveal opacity-0 translate-y-8 transition-all duration-700 ease-out text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">Available Programs</h2>
            <p class="text-lg text-slate-500 max-w-2xl mx-auto">Select a course below to view the syllabus or enroll.</p>
        </div>

        {{-- FILTER & SEARCH ROW --}}
        <div class="flex flex-col-reverse lg:flex-row justify-between items-start lg:items-center mb-8 gap-6">
            
            {{-- LEFT: Badge Filter Pills --}}
            <div class="flex flex-wrap items-center gap-2 w-full lg:w-auto">
                <button type="button" data-filter="all"
                    class="filter-pill px-5 py-2.5 rounded-lg font-bold text-sm bg-blue-600 text-white shadow-sm border border-blue-600 transition-all cursor-pointer hover:-translate-y-0.5">
                    All Courses
                </button>
                @php
                    $uniqueBadges = $courses->pluck('badge')->filter()->unique()->values();
                @endphp
                @foreach($uniqueBadges as $badge)
                    <button type="button" data-filter="{{ strtolower($badge) }}"
                        class="filter-pill px-5 py-2.5 rounded-lg font-bold text-sm bg-white text-slate-600 border border-slate-200 transition-all cursor-pointer hover:-translate-y-0.5 shadow-sm hover:shadow">
                        {{ $badge }}
                    </button>
                @endforeach
            </div>

            {{-- RIGHT: Compact Search Bar --}}
            <div class="relative w-full lg:w-72 shrink-0">
                <svg class="w-5 h-5 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                <input type="text" id="courseSearch" placeholder="Search courses..."
                    class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all shadow-sm text-sm">
            </div>

        </div>

        {{-- Cards grid --}}
        <div id="coursesContainer" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-8">
            @forelse($courses as $course)
                <div class="course-card group reveal opacity-0 translate-y-8 transition-all duration-700 ease-out
                            bg-white rounded-3xl shadow-sm border border-slate-200
                            overflow-hidden hover:shadow-2xl hover:-translate-y-2
                            flex flex-col transition-all duration-300 relative h-full min-h-[520px]"
                    data-title="{{ strtolower($course->title) }}"
                    data-acronym="{{ strtolower($course->acronym) }}"
                    data-badge="{{ strtolower($course->badge) }}"
                    data-description="{{ strtolower($course->description) }}">

                    {{-- Top accent bar --}}
                    <div class=" w-full shrink-0"></div>

                    {{-- Badge chip --}}
                    @if ($course->badge)
                        @php
                            $badgeLower = strtolower($course->badge);
                            $badgeColor = str_contains($badgeLower, 'new')
                                ? 'bg-emerald-500'
                                : (str_contains($badgeLower, 'best') || str_contains($badgeLower, 'popular')
                                    ? 'bg-blue-500'
                                    : (str_contains($badgeLower, 'sale') || str_contains($badgeLower, 'discount')
                                        ? 'bg-rose-500'
                                        : 'bg-blue-500'));
                        @endphp
                        <div class="absolute top-6 right-4 {{ $badgeColor }} text-white text-[10px] font-bold px-3 py-1 rounded-full z-20 shadow-sm uppercase tracking-wide">
                            {{ $course->badge }}
                        </div>
                    @endif

                    {{-- Thumbnail --}}
                    <div class="h-40 flex items-center justify-center relative overflow-hidden {{ $course->image_path ? '' : 'bg-' . $course->bg_color }}">
                        @if ($course->image_path)
                            <img src="{{ asset('storage/' . $course->image_path) }}"
                                class="absolute inset-0 w-full h-full object-cover z-0 group-hover:scale-110 transition-transform duration-500 ease-out"
                                alt="{{ $course->acronym }} Cover">
                            <div class="absolute inset-0 bg-slate-900/60 group-hover:bg-slate-900/50 transition-colors duration-300 z-0"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-tr from-black/40 to-transparent z-0"></div>
                        @endif
                        <span class="relative text-2xl font-black text-white tracking-widest z-10">{{ $course->acronym }}</span>
                    </div>

                    {{-- Card body --}}
                    <div class="p-6 flex flex-col flex-grow">
                        <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-blue-700 transition-colors duration-300">{{ $course->title }}</h3>
                        <p class="text-slate-500 mb-7 text-sm flex-grow leading-relaxed">{{ $course->description }}</p>

                        {{-- Module / lesson quick stats --}}
                        @php
                            $moduleCount = $course->modules->count();
                            $lessonCount = $course->modules->sum(fn ($module) => $module->lessons->count());
                        @endphp
                        <div class="flex items-center gap-4 text-xs font-semibold text-slate-500 mb-7 pb-5 border-b border-slate-100">
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                                {{ $moduleCount }} {{ Str::plural('Module', $moduleCount) }}
                            </span>
                            <span class="flex items-center gap-1.5">
                                <svg class="w-4 h-4 text-blue-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ $lessonCount }} {{ Str::plural('Lesson', $lessonCount) }}
                            </span>
                        </div>

                        <div class="mb-7">
                            <span class="text-3xl font-extrabold text-slate-900">₱{{ number_format($course->price, 0) }}</span>
                            <span class="block text-[11px] text-slate-400 font-medium mt-0.5">One-time payment</span>
                        </div>

                        <button type="button" onclick="openDetailsModal('detailsModal-{{ $course->id }}')"
                            class="w-full bg-blue-50 text-blue-700 group-hover:bg-blue-600 group-hover:text-white py-3.5 rounded-xl font-bold transition-colors duration-300 flex items-center justify-center gap-2 cursor-pointer">
                            View Details
                            <svg class="w-4 h-4 transition-transform duration-300 group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 text-center">
                    <div class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-slate-800 mb-2">More Courses Coming Soon</h3>
                    <p class="text-slate-500">We are currently preparing new reviewer materials. Check back later!</p>
                </div>
            @endforelse
        </div>

        {{-- No-results fallback --}}
        <div id="noResultsState" class="hidden py-16 text-center">
            <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-2">No Matching Programs</h3>
            <p class="text-slate-500 mb-6">Try a different keyword or reset the filters.</p>
            <button type="button" id="resetFiltersBtn"
                class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-full font-bold text-lg transition-all shadow-lg shadow-blue-600/30 hover:-translate-y-1 cursor-pointer">
                Reset Filters
            </button>
        </div>

    </div>
</section>

{{-- =====================================================
     SYLLABUS MODALS
     ===================================================== --}}
@foreach ($courses as $course)
    <div id="detailsModal-{{ $course->id }}"
        class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">

        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"
            onclick="closeDetailsModal('detailsModal-{{ $course->id }}')"></div>

        {{-- Panel --}}
        <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-4 transform scale-95 transition-transform duration-300 opacity-0 overflow-hidden flex flex-col max-h-[85vh]"
            id="detailsModal-{{ $course->id }}Content">

            {{-- Modal header --}}
            <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 shrink-0">
                <div>
                    <h3 class="text-2xl font-bold text-slate-900">{{ $course->title }}</h3>
                    <p class="text-sm text-slate-500 mt-1">Course Syllabus</p>
                </div>
                <button onclick="closeDetailsModal('detailsModal-{{ $course->id }}')"
                    class="text-slate-400 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 rounded-full p-2.5 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            {{-- Scrollable module/lesson list --}}
            <!-- Added pb-10 to ensure the last card isn't too close to the footer inside the modal -->
            <div class="px-6 pt-6 pb-10 overflow-y-auto bg-slate-50/50 flex-grow">
                <div class="space-y-4">
                    @forelse($course->modules as $module)
                        <div class="bg-white border border-slate-200 rounded-2xl p-9 shadow-sm hover:shadow-md transition-shadow">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">
                                    M{{ $module->module_number }}
                                </div>
                                <h4 class="text-lg font-bold text-slate-800">{{ $module->module_title }}</h4>
                            </div>

                            @if ($module->lessons->count() > 0)
                                <ul class="mt-4 ml-5 space-y-3 border-l-2 border-slate-100 pl-5">
                                    @foreach ($module->lessons as $lesson)
                                        <li class="flex items-start gap-3 text-slate-600">
                                            <svg class="w-5 h-5 text-emerald-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                            <div class="leading-snug">
                                                <span class="font-semibold text-slate-700">Lesson {{ $lesson->lesson_number }}:</span>
                                                {{ $lesson->lesson_title }}
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="text-sm text-slate-400 italic mt-2 ml-14">No lessons added to this module yet.</p>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-10 bg-white rounded-2xl border border-slate-200 border-dashed">
                            <div class="w-16 h-16 bg-slate-50 text-slate-400 rounded-full flex items-center justify-center mx-auto mb-3">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                            <p class="text-slate-500 font-medium">Syllabus is currently being finalized.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            {{-- Modal footer --}}
            <div class="px-6 py-4 bg-white border-t border-slate-100 flex items-center justify-between shrink-0">
                <a href="{{ $course->enrollment_link }}" target="_blank" rel="noopener noreferrer" class="text-xs text-slate-400 hover:text-slate-600 underline">
                    Backup Google Form Link
                </a>
                <div class="flex items-center gap-3">
                    <button onclick="closeDetailsModal('detailsModal-{{ $course->id }}')"
                        class="px-5 py-2.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-colors cursor-pointer">
                        Close
                    </button>
                    <a href="{{ route('enroll.selection', ['course' => $course->id]) }}"
                        class="px-6 py-2.5 rounded-full font-bold bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-600/20 transition-all hover:-translate-y-0.5">
                        Enroll Now
                    </a>
                </div>
            </div>

        </div>
    </div>
@endforeach

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const searchInput = document.getElementById('courseSearch');
        const cards       = document.querySelectorAll('.course-card');
        const filterPills = document.querySelectorAll('.filter-pill');
        const container   = document.getElementById('coursesContainer');
        const noResults   = document.getElementById('noResultsState');
        const resetBtn    = document.getElementById('resetFiltersBtn');

        let activeFilter = 'all';
        let searchQuery  = '';

        function applyFilters() {
            let visible = 0;
            cards.forEach(card => {
                const matchSearch = !searchQuery ||
                    (card.dataset.title       || '').includes(searchQuery) ||
                    (card.dataset.acronym     || '').includes(searchQuery) ||
                    (card.dataset.description || '').includes(searchQuery);
                const matchFilter = activeFilter === 'all' || (card.dataset.badge || '') === activeFilter;
                const show = matchSearch && matchFilter;
                card.style.display = show ? 'flex' : 'none';
                if (show) visible++;
            });
            const empty = visible === 0 && cards.length > 0;
            container.classList.toggle('hidden', empty);
            noResults.classList.toggle('hidden', !empty);
        }

        let searchTimeout;
        if (searchInput) {
            searchInput.addEventListener('input', e => {
                clearTimeout(searchTimeout);
                searchTimeout = setTimeout(() => {
                    searchQuery = e.target.value.toLowerCase().trim();
                    applyFilters();
                }, 300);
            });
        }

        filterPills.forEach(pill => {
            pill.addEventListener('click', () => {
                filterPills.forEach(p => {
                    p.classList.remove('bg-blue-600', 'text-white', 'border-blue-600');
                    p.classList.add('bg-white', 'text-slate-600', 'border-slate-200');
                });
                pill.classList.remove('bg-white', 'text-slate-600', 'border-slate-200');
                pill.classList.add('bg-blue-600', 'text-white', 'border-blue-600');
                activeFilter = pill.dataset.filter || 'all';
                applyFilters();
            });
        });

        if (resetBtn) {
            resetBtn.addEventListener('click', () => {
                if (searchInput) searchInput.value = '';
                searchQuery = '';
                const allPill = document.querySelector('.filter-pill[data-filter="all"]');
                if (allPill) allPill.click();
            });
        }
    });

    function openDetailsModal(modalID) {
        const modal        = document.getElementById(modalID);
        const modalContent = document.getElementById(modalID + 'Content');
        if (!modal || !modalContent) return;

        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('opacity-0', 'scale-95');
            modalContent.classList.add('opacity-100', 'scale-100');
        }, 10);
    }

    function closeDetailsModal(modalID) {
        const modal        = document.getElementById(modalID);
        const modalContent = document.getElementById(modalID + 'Content');
        if (!modal || !modalContent) return;

        modal.classList.add('opacity-0');
        modalContent.classList.remove('opacity-100', 'scale-100');
        modalContent.classList.add('opacity-0', 'scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
            document.body.style.overflow = '';
        }, 300);
    }
</script>
@endsection