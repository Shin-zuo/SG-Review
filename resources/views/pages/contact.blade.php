@extends('layouts.app')

@section('title', 'Contact Us | SG-Review')

@section('content')
    <div class="pt-32 pb-24 md:pt-40">
        <div class="container mx-auto px-6 max-w-6xl">
            
            <div class="reveal opacity-0 translate-y-8 transition-all duration-700 ease-out text-center mb-16">
                <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 tracking-tight mb-4">Get in Touch</h1>
                <p class="text-lg text-slate-500 max-w-2xl mx-auto">Have questions about our REBLEX, CELE, or CSE reviewers? Need help with an order? Drop us a message and our team will get back to you within 24 hours.</p>
            </div>

            <div class="grid md:grid-cols-5 gap-12 bg-white rounded-3xl shadow-sm border border-slate-200 overflow-hidden">
                
                <div class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-100 ease-out md:col-span-2 bg-slate-900 p-10 text-white relative overflow-hidden flex flex-col justify-between">
                    <div class="absolute -bottom-24 -right-24 w-64 h-64 bg-blue-600 rounded-full blur-3xl opacity-50 pointer-events-none"></div>

                    <div class="relative z-10">
                        <h3 class="text-2xl font-bold mb-6">Contact Information</h3>
                        
                        <div class="space-y-6">
                            <div class="flex items-start gap-4">
                                <svg class="w-6 h-6 text-blue-400 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                <div>
                                    <p class="text-sm text-slate-400 font-medium">Email Us</p>
                                    <a href="mailto:support@sg-review.com" class="text-lg hover:text-blue-400 transition-colors">sgwebwork2025@gmail.com</a>
                                </div>
                            </div>

                            <div class="flex items-start gap-4">
                                <svg class="w-6 h-6 text-blue-400 mt-1 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.243-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <div>
                                    <p class="text-sm text-slate-400 font-medium">Office Location</p>
                                    <p class="text-lg">Makati City, Metro Manila<br>Philippines</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="relative z-10 mt-12">
                        <p class="text-sm text-slate-400 font-medium mb-4">Connect with us</p>
                        <div class="flex gap-4">
                            <a href="#" target="_blank" rel="noopener noreferrer" class="w-12 h-12 rounded-full bg-white/10 flex items-center justify-center hover:bg-blue-600 hover:scale-110 transition-all duration-300" aria-label="Facebook Page">
                                <svg class="w-6 h-6 fill-current" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.469h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.469h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="reveal opacity-0 translate-y-8 transition-all duration-700 delay-200 ease-out md:col-span-3 p-10">

                    @if(session('success'))
                      <div class="p-4 mb-6 text-sm text-emerald-700 bg-emerald-100 rounded-xl border border-emerald-200" role="alert">
                           <span class="font-bold">Success!</span> {{ session('success') }}
                      </div>
                    @endif
                    <form action="{{ route('contact.submit') }}" method="POST" class="space-y-6">
                        @csrf 

                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="space-y-2">
                                <label for="name" class="block text-sm font-semibold text-slate-700">Full Name</label>
                                <input type="text" id="name" name="name" required placeholder="Juan Dela Cruz" 
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="block text-sm font-semibold text-slate-700">Email Address</label>
                                <input type="email" id="email" name="email" required placeholder="juan@example.com" 
                                    class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                            </div>
                        </div>

                        <div class="space-y-2">
                            <label for="subject" class="block text-sm font-semibold text-slate-700">Subject</label>
                            <input type="text" id="subject" name="subject" required placeholder="Inquiry about CELE Reviewer" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200">
                        </div>

                        <div class="space-y-2">
                            <label for="message" class="block text-sm font-semibold text-slate-700">Message</label>
                            <textarea id="message" name="message" rows="5" required placeholder="How can we help you today?" 
                                class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all duration-200 resize-none"></textarea>
                        </div>

                        

                        <button type="submit" class="w-full md:w-auto px-8 py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-600/30 transition-all duration-300 hover:-translate-y-1 flex items-center justify-center gap-2">
                            Send Message
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        </button>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection