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
            
            <div class="reveal opacity-0 translate-y-8 transition-all duration-700 ease-out flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div class="text-left">
                    <h2 class="text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight">Choose Your Reviewer</h2>
                    <p class="text-slate-500 mt-4 text-lg">Start your journey to becoming a licensed professional.</p>
                </div>
                
                <a href="/courses" class="h-12 px-8 rounded-full bg-slate-900 text-white flex items-center justify-center font-bold hover:bg-slate-800 hover:shadow-lg transition-all duration-300 w-full md:w-auto text-center">
                    View All Courses
                </a>
            </div>

            <div class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-100 ease-out relative w-full group/carousel">
                
                <button class="scrollLeftBtn hidden md:flex absolute left-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-md border border-slate-200 items-center justify-center text-slate-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:scale-110 transition-all duration-300 opacity-0 md:group-hover/carousel:opacity-100 focus:opacity-100" aria-label="Scroll Left">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <div id="courseCarousel" class="flex gap-6 overflow-x-auto snap-x snap-mandatory pb-8 pt-4 md:px-14 scroll-smooth [scrollbar-width:none] [&::-webkit-scrollbar]:hidden">
                    
                    <div class="group snap-center shrink-0 w-[85vw] md:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-2 flex flex-col transition-all duration-300">
                        <div class="h-40 bg-slate-800 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-tr from-slate-900 to-slate-700 opacity-90"></div>
                            <span class="relative text-2xl font-black text-white tracking-widest z-10">REBLEX</span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Real Estate Broker</h3>
                            <p class="text-slate-500 mb-6 text-sm flex-grow">Comprehensive guide covering Fundamentals, Appraisal, and Real Estate Law.</p>
                            <div class="mb-5"><span class="text-3xl font-extrabold text-slate-900">₱5,000</span></div>
                            <a href="https://tinyurl.com/SGW-REALE-REBLEX-REVIEW" target="_blank" rel="noopener noreferrer" class="w-full bg-blue-50 text-blue-700 group-hover:bg-blue-600 group-hover:text-white py-3.5 rounded-xl font-bold transition-colors duration-300 block text-center">
                                Enroll Now
                            </a>
                        </div>
                    </div>

                    <div class="group snap-center shrink-0 w-[85vw] md:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] bg-white rounded-3xl shadow-md border-2 border-blue-500 overflow-hidden hover:shadow-xl hover:-translate-y-2 flex flex-col relative transition-all duration-300">
                        <div class="absolute top-4 right-4 bg-blue-500 text-white text-[10px] font-bold px-3 py-1 rounded-full z-20 shadow-sm uppercase tracking-wide">Most Popular</div>
                        <div class="h-40 bg-blue-600 flex items-center justify-center relative overflow-hidden">
                            <div class="absolute inset-0 bg-gradient-to-tr from-blue-700 to-cyan-500 opacity-90"></div>
                            <span class="relative text-2xl font-black text-white tracking-widest z-10">CELE</span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Civil Engineering</h3>
                            <p class="text-slate-500 mb-6 text-sm flex-grow">Master Mathematics, Surveying, Hydraulics, and Structural Design.</p>
                            <div class="mb-5"><span class="text-3xl font-extrabold text-slate-900">₱5,000</span></div>
                            <a href="https://tinyurl.com/SGW-CELE-REVIEW" target="_blank" rel="noopener noreferrer" class="w-full bg-blue-600 text-white hover:bg-blue-700 py-3.5 rounded-xl font-bold transition-colors duration-300 block text-center shadow-sm">
                                Enroll Now
                            </a>
                        </div>
                    </div>

                    <div class="group snap-center shrink-0 w-[85vw] md:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-2 flex flex-col transition-all duration-300">
                        <div class="h-40 bg-emerald-600 flex items-center justify-center relative overflow-hidden">
                             <div class="absolute inset-0 bg-gradient-to-tr from-emerald-700 to-teal-500 opacity-90"></div>
                            <span class="relative text-2xl font-black text-white tracking-widest z-10">CSE</span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Civil Service</h3>
                            <p class="text-slate-500 mb-6 text-sm flex-grow">Professional and Sub-Professional level logic, math, and general info.</p>
                            <div class="mb-5"><span class="text-3xl font-extrabold text-slate-900">₱1,000</span></div>
                            <a href="https://tinyurl.com/SGW-CSE-CET-AI-REVIEW" target="_blank" rel="noopener noreferrer" class="w-full bg-blue-50 text-blue-700 group-hover:bg-blue-600 group-hover:text-white py-3.5 rounded-xl font-bold transition-colors duration-300 block text-center">
                                Enroll Now
                            </a>
                        </div>
                    </div>

                    <div class="group snap-center shrink-0 w-[85vw] md:w-[calc(50%-0.75rem)] lg:w-[calc(33.333%-1rem)] bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden hover:shadow-xl hover:-translate-y-2 flex flex-col transition-all duration-300">
                        <div class="h-40 bg-purple-600 flex items-center justify-center relative overflow-hidden">
                             <div class="absolute inset-0 bg-gradient-to-tr from-purple-700 to-pink-500 opacity-90"></div>
                            <span class="relative text-2xl font-black text-white tracking-widest z-10">LET</span>
                        </div>
                        <div class="p-6 flex flex-col flex-grow">
                            <h3 class="text-xl font-bold text-slate-900 mb-2">Prof. Teachers</h3>
                            <p class="text-slate-500 mb-6 text-sm flex-grow">Comprehensive coverage of Gen Ed, Prof Ed, and your specific Major.</p>
                            <div class="mb-5"><span class="text-3xl font-extrabold text-slate-900">₱2,500</span></div>
                            <a href="#" class="w-full bg-blue-50 text-blue-700 group-hover:bg-blue-600 group-hover:text-white py-3.5 rounded-xl font-bold transition-colors duration-300 block text-center">
                                Coming Soon
                            </a>
                        </div>
                    </div>

                </div>

                <button class="scrollRightBtn hidden md:flex absolute right-0 top-1/2 -translate-y-1/2 z-20 w-12 h-12 bg-white/90 backdrop-blur-sm rounded-full shadow-md border border-slate-200 items-center justify-center text-slate-700 hover:bg-blue-600 hover:text-white hover:border-blue-600 hover:scale-110 transition-all duration-300 opacity-0 md:group-hover/carousel:opacity-100 focus:opacity-100" aria-label="Scroll Right">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>

            </div>

            <div class="flex md:hidden justify-center gap-6 mt-4">
                <button class="scrollLeftBtn w-12 h-12 rounded-full shadow-sm border border-slate-200 flex items-center justify-center text-slate-700 hover:bg-blue-600 hover:text-white transition-all duration-300 bg-white" aria-label="Scroll Left">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button class="scrollRightBtn w-12 h-12 rounded-full shadow-sm border border-slate-200 flex items-center justify-center text-slate-700 hover:bg-blue-600 hover:text-white transition-all duration-300 bg-white" aria-label="Scroll Right">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

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
                            carousel.scrollTo({ left: carousel.scrollWidth, behavior: 'smooth' });
                        } else {
                            carousel.scrollBy({ left: -getScrollAmount(), behavior: 'smooth' });
                        }
                    });
                });

                // Attach logic to all Right Buttons
                rightBtns.forEach(btn => {
                    btn.addEventListener('click', () => {
                        // If at the end, loop back to the beginning
                        if (Math.ceil(carousel.scrollLeft + carousel.clientWidth) >= carousel.scrollWidth - 10) {
                            carousel.scrollTo({ left: 0, behavior: 'smooth' });
                        } else {
                            carousel.scrollBy({ left: getScrollAmount(), behavior: 'smooth' });
                        }
                    });
                });
            }
        });
    </script>
@endsection
