@extends('layouts.app')

@section('content')
    <header class="relative container mx-auto px-6 pt-40 pb-24 md:pt-48 md:pb-32 text-center overflow-hidden">
        <div
            class="absolute top-0 left-1/2 -translate-x-1/2 w-full h-full max-w-3xl bg-blue-50 blur-3xl rounded-full -z-10 opacity-60">
        </div>
        <div class="max-w-4xl mx-auto">
            <span
                class="reveal opacity-0 translate-y-8 transition-all duration-700 ease-out text-blue-600 font-bold tracking-widest uppercase text-xs block mb-4">Your
                License Awaits</span>
            <h1
                class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-100 ease-out text-5xl md:text-7xl font-extrabold mb-8 leading-tight tracking-tight">
                Ace Your PRC Exam on the <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-cyan-500">First Try.</span>
            </h1>
            <p
                class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-200 ease-out text-lg md:text-xl text-slate-600 mb-12 max-w-2xl mx-auto">
                Comprehensive, up-to-date, and easy-to-digest reviewers for REBLEX, CELE, and Civil Service exams. Stop
                guessing and start passing.
            </p>
            <div
                class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-300 ease-out flex flex-col sm:flex-row justify-center gap-4">
                <a href="#reviewers"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-4 rounded-full font-bold text-lg transition-all shadow-lg shadow-blue-600/30 hover:-translate-y-1">Browse
                    Reviewers</a>
                <a href="#features"
                    class="bg-white hover:bg-slate-50 text-slate-700 border border-slate-200 px-8 py-4 rounded-full font-bold text-lg transition-all shadow-sm hover:-translate-y-1">See
                    How It Works</a>
            </div>
        </div>
    </header>

    <section id="features" class="bg-white py-24 border-y border-slate-200/60">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="reveal opacity-0 translate-y-8 transition-all duration-700 ease-out text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Why Choose SG-Review?</h2>
                <p class="text-slate-500 mt-4 text-lg">Built by topnotchers, engineered for your success.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <div
                    class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-100 ease-out p-8 bg-slate-50/50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div
                        class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-900">Updated Content</h3>
                    <p class="text-slate-600 leading-relaxed">Our materials are strictly aligned with the absolute latest
                        PRC table of specifications.</p>
                </div>
                <div
                    class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-200 ease-out p-8 bg-slate-50/50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div
                        class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-900">High Yield Focus</h3>
                    <p class="text-slate-600 leading-relaxed">No fluff. We focus relentlessly on the core concepts and
                        frequently asked questions.</p>
                </div>
                <div
                    class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-300 ease-out p-8 bg-slate-50/50 rounded-3xl border border-slate-100 hover:bg-white hover:shadow-xl transition-all duration-300 group">
                    <div
                        class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center mb-6 group-hover:scale-110 group-hover:bg-blue-600 group-hover:text-white transition-all duration-300">
                        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-3 text-slate-900">Mock Exams</h3>
                    <p class="text-slate-600 leading-relaxed">Test your knowledge with practice questions designed to
                        simulate real exam pressure.</p>
                </div>
            </div>
        </div>
    </section>

    <section id="reviewers" class="py-24 bg-slate-50">
        <div class="container mx-auto px-6 max-w-7xl">

            <div
                class="reveal opacity-0 translate-y-8 transition-all duration-700 ease-out flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="text-left">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Choose Your Reviewer</h2>
                    <p class="text-slate-500 mt-4 text-lg">Start your journey to becoming a licensed professional.</p>
                </div>

                <a href="/courses"
                    class="h-12 px-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold hover:bg-slate-800 hover:shadow-lg transition-all duration-300 w-full md:w-auto text-center">
                    View All Courses
                </a>
            </div>

            <div
                class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-100 ease-out relative w-full group/carousel">

                <button
                    class="scrollLeftBtn hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-md border border-slate-200 items-center justify-center text-slate-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:scale-110 transition-all duration-300 opacity-0 md:group-hover/carousel:opacity-100 focus:opacity-100"
                    aria-label="Scroll Left">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>

                <div id="courseCarousel"
                    class="flex gap-6 overflow-x-auto snap-x snap-mandatory pb-8 pt-4 md:px-14 scroll-smooth [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">

                    @forelse($courses as $course)
                        <div
                            class="group snap-center shrink-0 w-[85vw] md:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-2 flex flex-col transition-all duration-300 relative">

                            @if ($course->badge)
                                <div
                                    class="absolute top-4 right-4 bg-blue-500 text-white text-[10px] font-bold px-3 py-1 rounded-full z-20 shadow-sm uppercase tracking-wide">
                                    {{ $course->badge }}
                                </div>
                            @endif

                            <div
                                class="h-40 flex items-center justify-center relative overflow-hidden {{ $course->image_path ? '' : 'bg-' . $course->bg_color }}">
                                @if ($course->image_path)
                                    <img src="{{ asset('storage/' . $course->image_path) }}"
                                        class="absolute inset-0 w-full h-full object-cover z-0"
                                        alt="{{ $course->acronym }} Cover">
                                    <div class="absolute inset-0 bg-slate-900/60 z-0"></div>
                                @else
                                    <div class="absolute inset-0 bg-gradient-to-tr from-black/40 to-transparent z-0"></div>
                                @endif

                                <span
                                    class="relative text-2xl font-black text-white tracking-widest z-10">{{ $course->acronym }}</span>
                            </div>

                            <div class="p-6 flex flex-col flex-grow">
                                <h3 class="text-xl font-bold text-slate-900 mb-2">{{ $course->title }}</h3>
                                <p class="text-slate-500 mb-6 text-sm flex-grow line-clamp-2">{{ $course->description }}</p>

                                <div class="mb-5"><span
                                        class="text-3xl font-extrabold text-slate-900">₱{{ number_format($course->price, 0) }}
                                        </span>
                                </div>

                                {{-- <a href="{{ $course->enrollment_link }}" target="_blank" rel="noopener noreferrer"
                                    class="w-full bg-blue-50 text-blue-700 group-hover:bg-blue-600 group-hover:text-white py-3.5 rounded-xl font-bold transition-colors duration-300 block text-center">
                                    Enroll Now
                                </a> --}}
                                <button type="button" onclick="openModal('detailsModal-{{ $course->id }}')" 
    class="w-full bg-blue-50 text-blue-700 group-hover:bg-blue-600 group-hover:text-white py-3.5 rounded-xl font-bold transition-colors duration-300 block text-center cursor-pointer">
    View Details
</button>
                            </div>
                        </div>
                    @empty
                        <div class="w-full py-16 text-center">
                            <div
                                class="w-16 h-16 bg-blue-50 text-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-bold text-slate-800 mb-2">More Courses Coming Soon</h3>
                            <p class="text-slate-500">We are currently preparing new reviewer materials. Check back later!
                            </p>
                        </div>
                    @endforelse

                </div>

                <button
                    class="scrollRightBtn hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-md border border-slate-200 items-center justify-center text-slate-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:scale-110 transition-all duration-300 opacity-0 md:group-hover/carousel:opacity-100 focus:opacity-100"
                    aria-label="Scroll Right">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>

            </div>

            <div class="flex md:hidden justify-center gap-6 mt-4">
                <button
                    class="scrollLeftBtn w-12 h-12 rounded-full shadow-sm border border-slate-200 flex items-center justify-center text-slate-700 hover:bg-blue-600 hover:text-white transition-all duration-300 bg-white"
                    aria-label="Scroll Left">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button
                    class="scrollRightBtn w-12 h-12 rounded-full shadow-sm border border-slate-200 flex items-center justify-center text-slate-700 hover:bg-blue-600 hover:text-white transition-all duration-300 bg-white"
                    aria-label="Scroll Right">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

        </div>

        @foreach($courses as $course)
<div id="detailsModal-{{ $course->id }}"
    class="fixed inset-0 z-50 flex items-center justify-center hidden opacity-0 transition-opacity duration-300">

    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="closeModal('detailsModal-{{ $course->id }}')"></div>

    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-4 transform scale-95 transition-transform duration-300 opacity-0 overflow-hidden flex flex-col max-h-[85vh]"
        id="detailsModal-{{ $course->id }}Content">

        <div class="flex items-center justify-between px-6 py-5 border-b border-slate-100 shrink-0">
            <div>
                <h3 class="text-2xl font-bold text-slate-900">{{ $course->title }}</h3>
                <p class="text-sm text-slate-500 mt-1">Course Syllabus</p>
            </div>
            <button onclick="closeModal('detailsModal-{{ $course->id }}')"
                class="text-slate-400 hover:text-slate-700 bg-slate-50 hover:bg-slate-100 rounded-full p-2.5 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="px-6 py-6 overflow-y-auto bg-slate-50/50 flex-grow">
            <div class="space-y-4">
                @forelse($course->modules as $module)
                    <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-3 mb-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-700 font-bold flex items-center justify-center shrink-0">
                                M{{ $module->module_number }}
                            </div>
                            <h4 class="text-lg font-bold text-slate-800">{{ $module->module_title }}</h4>
                        </div>

                        @if($module->lessons->count() > 0)
                            <ul class="mt-4 ml-5 space-y-3 border-l-2 border-slate-100 pl-5">
                                @foreach($module->lessons as $lesson)
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

        <div class="px-6 py-4 bg-white border-t border-slate-100 flex justify-end gap-3 shrink-0">
            <button onclick="closeModal('detailsModal-{{ $course->id }}')"
                class="px-5 py-2.5 rounded-xl font-semibold text-slate-600 hover:bg-slate-100 transition-colors">
                Close
            </button>
            <a href="{{ $course->enrollment_link }}" target="_blank" rel="noopener noreferrer"
                class="px-6 py-2.5 rounded-xl font-bold bg-blue-600 text-white hover:bg-blue-700 shadow-md shadow-blue-600/20 transition-all">
                Enroll Now
            </a>
        </div>

    </div>
</div>
@endforeach
    </section>

    <section id="agent" class="bg-white py-24 border-y border-slate-200/60">
        <div class="container mx-auto px-6 max-w-6xl">
            <div class="reveal opacity-0 translate-y-8 transition-all duration-700 ease-out text-center mb-16">
                <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Want To Be Part Of Our
                    Growing Team?</h2>
            </div>

            <form method="POST" action="{{ route('agents.store') }}"
                class="max-w-3xl mx-auto bg-slate-50 border border-slate-200 rounded-3xl p-8 md:p-12 shadow-sm hover:shadow-lg transition-all duration-300">
                @csrf
                <div class="grid md:grid-cols-2 gap-6">
                    <input type="text" placeholder="Full Name"
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                    <input type="email" placeholder="Email Address"
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                    <input type="text" placeholder="Phone Number"
                        class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                    <div class="relative w-full">
                        <div class="relative">
                            <input type="text" id="location-input" name="location" placeholder="Loading locations..."
                                disabled autocomplete="off"
                                class="w-full px-4 py-3 rounded-lg border border-slate-300 focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300 disabled:bg-slate-100 disabled:cursor-not-allowed bg-white">
                            <!-- Decorative Chevron Icon -->
                            <div
                                class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </div>
                        </div>

                        <!-- The Custom Styled Dropdown Menu -->
                        <ul id="custom-dropdown"
                            class="absolute z-50 w-full mt-2 bg-white border border-slate-200 rounded-lg shadow-xl max-h-60 overflow-y-auto hidden divide-y divide-slate-100 text-sm">
                            <!-- JS will inject list items here -->
                        </ul>
                    </div>
                </div>
                <button type="submit"
                    class="mt-6 w-full md:w-auto bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-full font-bold text-lg transition-all shadow-lg shadow-blue-600/30 hover:-translate-y-1">Register</button>
            </form>
        </div>
    </section>


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const carousel = document.getElementById('courseCarousel');
            // Use querySelectorAll to grab both Mobile and Desktop buttons
            const leftBtns = document.querySelectorAll('.scrollLeftBtn');
            const rightBtns = document.querySelectorAll('.scrollRightBtn');

            if (leftBtns.length > 0 && rightBtns.length > 0 && carousel) {
                const getScrollAmount = () => {
                    const card = carousel.querySelector('div.shrink-0');
                    return card ? card.offsetWidth + 24 : 324;
                };

                // Attach logic to all Left Buttons
                leftBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        // If at the beginning, loop to the end
                        if (carousel.scrollLeft <= 10) {
                            carousel.scrollTo({
                                left: carousel.scrollWidth,
                                behavior: 'smooth'
                            });
                        } else {
                            carousel.scrollBy({
                                left: -getScrollAmount(),
                                behavior: 'smooth'
                            });
                        }
                    });
                });

                // Attach logic to all Right Buttons
                rightBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        // If at the end, loop back to the beginning
                        if (Math.ceil(carousel.scrollLeft + carousel.clientWidth) >= carousel
                            .scrollWidth - 10) {
                            carousel.scrollTo({
                                left: 0,
                                behavior: 'smooth'
                            });
                        } else {
                            carousel.scrollBy({
                                left: getScrollAmount(),
                                behavior: 'smooth'
                            });
                        }
                    });
                });
            }
        });


        //    this is for the city selections in form, it fetches the provinces and cities from the PSGC API and populates the datalist for the input field.
        document.addEventListener("DOMContentLoaded", async () => {
            const inputEl = document.getElementById("location-input");
            const dropdownEl = document.getElementById("custom-dropdown");

            // We will store all fetched locations in this array
            let allLocations = [];

            const PROVINCES_API = "https://psgc.gitlab.io/api/provinces.json";
            const CITIES_API = "https://psgc.gitlab.io/api/cities-municipalities.json";

            try {
                const [provincesRes, citiesRes] = await Promise.all([
                    fetch(PROVINCES_API),
                    fetch(CITIES_API)
                ]);

                const provinces = await provincesRes.json();
                const cities = await citiesRes.json();

                // Format strings to match your preference
                provinces.forEach(prov => allLocations.push(`${prov.name} (Province)`));
                cities.forEach(city => allLocations.push(`${city.name} City/Municipality`));

                // Sort alphabetically for a better user experience
                allLocations.sort();

                inputEl.placeholder = "Search City or Province...";
                inputEl.disabled = false;

            } catch (error) {
                console.error("Failed to load locations:", error);
                inputEl.placeholder = "City/Province (Type manually)";
                inputEl.disabled = false;
            }

            // Function to render the list based on search query
            function renderDropdown(filterText = "") {
                dropdownEl.innerHTML = ""; // Clear existing

                // Filter locations based on typing (case insensitive)
                const filtered = allLocations.filter(loc =>
                    loc.toLowerCase().includes(filterText.toLowerCase())
                );

                if (filtered.length === 0) {
                    dropdownEl.innerHTML = `<li class="px-4 py-3 text-slate-500 italic">No matches found</li>`;
                    return;
                }

                // Only show top 100 results so the browser doesn't freeze when rendering
                filtered.slice(0, 100).forEach(loc => {
                    const li = document.createElement("li");
                    li.textContent = loc;
                    // Add your Tailwind hover styles here!
                    li.className =
                        "px-4 py-2.5 cursor-pointer text-slate-700 hover:bg-blue-50 hover:text-blue-700 transition-colors duration-150";

                    // When a user clicks a dropdown item, fill the input and hide dropdown
                    li.addEventListener("click", () => {
                        inputEl.value = loc;
                        dropdownEl.classList.add("hidden");
                    });

                    dropdownEl.appendChild(li);
                });
            }

            // --- Event Listeners for Interaction ---

            // 1. Show list when clicking into the input
            inputEl.addEventListener("focus", () => {
                renderDropdown(inputEl.value);
                dropdownEl.classList.remove("hidden");
            });

            // 2. Filter list as user types
            inputEl.addEventListener("input", (e) => {
                renderDropdown(e.target.value);
                dropdownEl.classList.remove("hidden");
            });

            // 3. Hide list if user clicks somewhere else on the page
            document.addEventListener("click", (e) => {
                if (!inputEl.contains(e.target) && !dropdownEl.contains(e.target)) {
                    dropdownEl.classList.add("hidden");
                }
            });
        });


        // Open Modal Function
        function openModal(modalID) {
            const modal = document.getElementById(modalID);
            const modalContent = document.getElementById(modalID + 'Content');

            // Remove hidden class first so it exists in the DOM
            modal.classList.remove('hidden');

            // Small delay to allow the browser to register the element before animating
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('opacity-0', 'scale-95');
                modalContent.classList.add('opacity-100', 'scale-100');
            }, 10);
        }

        function closeModal(modalID) {
            const modal = document.getElementById(modalID);
            const modalContent = document.getElementById(modalID + 'Content');

            // Start the fade out animation
            modal.classList.add('opacity-0');
            modalContent.classList.remove('opacity-100', 'scale-100');
            modalContent.classList.add('opacity-0', 'scale-95');

            // Wait for the animation to finish before completely hiding it (300ms matches Tailwind duration)
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
@endsection
