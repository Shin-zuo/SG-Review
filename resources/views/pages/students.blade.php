@extends('layouts.admin')

@section('title', 'Manage Students | SG-Review')
@section('header_title', 'Students')

@section('content')
    <div class="w-full max-w-7xl mx-auto py-6 space-y-12">

        {{-- Top Header Section (Clean & Simple just like reviewer.blade.php) --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Students Database</h2>
                <p class="text-slate-500 text-sm">Review student enrollments and monitor Google Classroom invitations.</p>
            </div>

            <div class="flex items-center gap-3">
                <a href="{{ route('google.auth') }}"
                    class="bg-white border border-slate-200 hover:bg-slate-50 text-slate-700 px-4 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                    OAuth Token Setup
                </a>
                <a href="{{ route('reviewers') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-lg text-sm font-semibold transition shadow-sm">
                    View Courses
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl font-medium text-sm flex items-center justify-between">
                <span>⚡ {{ session('success') }}</span>
            </div>
        @endif
        @if(session('error'))
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl font-medium text-sm flex items-center justify-between">
                <span>⚠️ {{ session('error') }}</span>
            </div>
        @endif

        {{-- Summary Cards (Clean spacing & simple typography) --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Enrolled</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalStudentsCount ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl">
                    👥
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Premium Access</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalPremiumPaid ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl">
                    ⭐
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Active Free Trials</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalActiveTrials ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl">
                    ⏳
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Upgraded to Premium</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalUpgradedTrials ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-purple-50 text-purple-600 flex items-center justify-center text-xl">
                    🚀
                </div>
            </div>
        </div>

        {{-- ===================================================================== --}}
        {{-- TABLE 1: PREMIUM ACCESS STUDENTS --}}
        {{-- ===================================================================== --}}
        <div class="space-y-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-blue-600"></span>
                        Premium Reviewer Access
                    </h3>
                    <p class="text-xs text-slate-500">Students enrolled and verified through Xendit GCash checkout.</p>
                </div>
                <span class="px-3 py-1 bg-blue-50 text-blue-700 border border-blue-100 font-semibold text-xs rounded-full shrink-0">
                    {{ $premiumStudents->total() }} Enrolled
                </span>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <th class="py-3.5 px-6">Reference ID</th>
                                <th class="py-3.5 px-6">Student Info</th>
                                <th class="py-3.5 px-6">Course</th>
                                <th class="py-3.5 px-6">Payment Status</th>
                                <th class="py-3.5 px-6">Google Classroom</th>
                                <th class="py-3.5 px-6">Enrolled Date</th>
                                <th class="py-3.5 px-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            @forelse($premiumStudents as $student)
                                <tr class="hover:bg-blue-50/70 transition-colors cursor-pointer" 
                                    data-student="{{ json_encode($student) }}" 
                                    data-course-title="{{ $student->course->title ?? 'N/A' }}" 
                                    data-course-acronym="{{ $student->course->acronym ?? 'N/A' }}" 
                                    onclick="openStudentModal(this)"
                                    title="Click row to view full student details">
                                    <td class="py-4 px-6 font-mono text-sm font-bold text-slate-600">
                                        {{ Str::limit($student->reference_id, 12) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-extrabold text-slate-950 text-base">{{ $student->student_name }}</div>
                                        <div class="text-sm font-bold text-blue-700 mt-0.5">{{ $student->student_email }}</div>
                                        <div class="text-sm font-semibold text-slate-600 mt-1">{{ $student->student_phone }} &bull; {{ $student->school_name }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-900 bg-slate-200/80 px-3 py-1.5 rounded-lg text-sm inline-block">
                                            {{ $student->course->acronym ?? ($student->course->title ?? 'Course #' . $student->course_id) }}
                                        </span>
                                        @if($student->referral_code)
                                            <div class="text-xs text-amber-700 font-bold mt-1.5">
                                                Ref: {{ $student->referral_code }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-black text-slate-950 text-base">₱{{ number_format($student->amount, 2) }}</div>
                                        <div class="mt-1.5">
                                            @if($student->status === 'paid' || $student->is_paid)
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                                    Paid (GCash)
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 capitalize border border-amber-300">
                                                    {{ $student->status }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($student->google_classroom_enrolled)
                                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-blue-100 text-blue-900 border border-blue-300">
                                                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                                Invite Sent
                                            </span>
                                        @else
                                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">Pending Dispatch</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-sm font-bold text-slate-700">
                                        {{ $student->created_at ? $student->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6" onclick="event.stopPropagation()">
                                        <div class="flex items-center gap-2">
                                            @if($student->status !== 'paid' && !$student->is_paid)
                                                <form action="{{ route('students.approve', $student->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs rounded-lg transition shadow-sm">
                                                        Approve & Invite
                                                    </button>
                                                </form>
                                            @else
                                                <form action="{{ route('students.resend_invite', $student->id) }}" method="POST" title="Resend Classroom Invite">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-lg transition border border-slate-200">
                                                        Resend
                                                    </button>
                                                </form>
                                            @endif
                                            @if($student->google_classroom_enrolled)
                                                <form action="{{ route('students.unenroll', $student->id) }}" method="POST" title="Revoke Classroom Access">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold text-xs rounded-lg transition border border-amber-200" onclick="return confirm('Revoke Google Classroom access for {{ $student->student_email }}?')">
                                                        Unenroll
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" title="Delete record and unenroll from Classroom">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-xs rounded-lg transition border border-red-200" onclick="return confirm('Are you sure you want to completely remove {{ $student->student_email }}? This will also unenroll them from Google Classroom.')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colSpan="7" class="py-12 text-center text-slate-400">
                                        No premium students enrolled yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($premiumStudents->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $premiumStudents->appends(['free_page' => $freeTrialStudents->currentPage()])->links() }}
                    </div>
                @endif
            </div>
        </div>

        {{-- ===================================================================== --}}
        {{-- TABLE 2: FREE TRIAL ACCESS STUDENTS --}}
        {{-- ===================================================================== --}}
        <div class="space-y-4 pt-4">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-2">
                <div>
                    <h3 class="text-lg font-bold text-slate-800 flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                        Free Trial Access (7-Day)
                    </h3>
                    <p class="text-xs text-slate-500">Students with 7-day review access via automated Google Classroom invitations.</p>
                </div>
                <span class="px-3 py-1 bg-amber-50 text-amber-700 border border-amber-100 font-semibold text-xs rounded-full shrink-0">
                    {{ $freeTrialStudents->total() }} Active
                </span>
            </div>

            <div class="bg-white border border-slate-200 rounded-2xl shadow-sm overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 border-b border-slate-200 text-xs font-semibold text-slate-600 uppercase tracking-wider">
                                <th class="py-3.5 px-6">Reference ID</th>
                                <th class="py-3.5 px-6">Student Info</th>
                                <th class="py-3.5 px-6">Course</th>
                                <th class="py-3.5 px-6">Trial Status</th>
                                <th class="py-3.5 px-6">Google Classroom</th>
                                <th class="py-3.5 px-6">Enrolled Date</th>
                                <th class="py-3.5 px-6">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm text-slate-700">
                            @forelse($freeTrialStudents as $student)
                                <tr class="hover:bg-blue-50/70 transition-colors cursor-pointer" 
                                    data-student="{{ json_encode($student) }}" 
                                    data-course-title="{{ $student->course->title ?? 'N/A' }}" 
                                    data-course-acronym="{{ $student->course->acronym ?? 'N/A' }}" 
                                    onclick="openStudentModal(this)"
                                    title="Click row to view full student details">
                                    <td class="py-4 px-6 font-mono text-sm font-bold text-slate-600">
                                        {{ Str::limit($student->reference_id, 12) }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-extrabold text-slate-950 text-base">{{ $student->student_name }}</div>
                                        <div class="text-sm font-bold text-blue-700 mt-0.5">{{ $student->student_email }}</div>
                                        <div class="text-sm font-semibold text-slate-600 mt-1">{{ $student->student_phone }} &bull; {{ $student->school_name }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="font-bold text-slate-900 bg-slate-200/80 px-3 py-1.5 rounded-lg text-sm inline-block">
                                            {{ $student->course->acronym ?? ($student->course->title ?? 'Course #' . $student->course_id) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($student->status === 'upgraded')
                                            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-extrabold bg-purple-100 text-purple-900 border border-purple-300">
                                                <span>⭐</span> Upgraded to Premium
                                            </span>
                                        @elseif($student->trial_expires_at)
                                            @if($student->trial_expires_at->isPast() || $student->status === 'expired')
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-extrabold bg-red-100 text-red-900 border border-red-300">
                                                    Expired
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300">
                                                    Expires {{ $student->trial_expires_at->format('M d') }}
                                                </span>
                                            @endif
                                        @else
                                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1 rounded-full border border-slate-200">7 Days access</span>
                                        @endif

                                        @if($student->extension_status === 'pending')
                                            <div class="mt-2.5 p-2.5 bg-purple-100 border border-purple-300 rounded-xl text-xs">
                                                <span class="font-extrabold text-purple-950 flex items-center gap-1.5">
                                                    <span class="w-2.5 h-2.5 rounded-full bg-purple-600 animate-ping"></span>
                                                    Requested +3 Days Extension
                                                </span>
                                                @if($student->extension_reason)
                                                    <p class="text-xs font-semibold text-purple-900 mt-1 italic">"{{ $student->extension_reason }}"</p>
                                                @endif
                                            </div>
                                        @elseif($student->extension_status === 'approved')
                                            <div class="mt-2 inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-extrabold bg-emerald-100 text-emerald-900 border border-emerald-300">
                                                ✓ +3 Days Extended
                                            </div>
                                        @elseif($student->extension_status === 'rejected')
                                            <div class="mt-2 inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-slate-200 text-slate-700">
                                                ✕ Extension Rejected
                                            </div>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6">
                                        @if($student->google_classroom_enrolled)
                                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-blue-100 text-blue-900 border border-blue-300">
                                                <span class="w-2 h-2 rounded-full bg-blue-600"></span>
                                                Invite Sent
                                            </span>
                                        @elseif($student->status === 'expired')
                                            <span class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-extrabold bg-red-100 text-red-900 border border-red-300">
                                                <span class="w-2 h-2 rounded-full bg-red-600"></span>
                                                Access Revoked
                                            </span>
                                        @else
                                            <span class="text-xs font-bold text-slate-600 bg-slate-100 px-3 py-1.5 rounded-full border border-slate-200">Pending Dispatch</span>
                                        @endif
                                    </td>
                                    <td class="py-4 px-6 text-sm font-bold text-slate-700">
                                        {{ $student->created_at ? $student->created_at->format('M d, Y') : 'N/A' }}
                                    </td>
                                    <td class="py-4 px-6" onclick="event.stopPropagation()">
                                        <div class="flex items-center flex-wrap gap-2">
                                            @if($student->extension_status === 'pending')
                                                <form action="{{ route('students.approve_extension', $student->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1.5 bg-purple-600 hover:bg-purple-700 text-white font-bold text-xs rounded-lg transition shadow-sm" onclick="return confirm('Approve +3 Days Extension for {{ $student->student_email }}?')">
                                                        Approve +3d
                                                    </button>
                                                </form>
                                                <form action="{{ route('students.reject_extension', $student->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="px-2 py-1.5 bg-slate-200 hover:bg-slate-300 text-slate-700 font-semibold text-xs rounded-lg transition" onclick="return confirm('Reject extension request for {{ $student->student_email }}?')">
                                                        Reject
                                                    </button>
                                                </form>
                                            @endif

                                            <form action="{{ route('students.resend_invite', $student->id) }}" method="POST" title="Resend Classroom Invite">
                                                @csrf
                                                <button type="submit" class="px-2.5 py-1.5 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold text-xs rounded-lg transition border border-slate-200">
                                                    Resend
                                                </button>
                                            </form>
                                            @if($student->google_classroom_enrolled && $student->status !== 'upgraded')
                                                <form action="{{ route('students.unenroll', $student->id) }}" method="POST" title="Revoke Classroom Access">
                                                    @csrf
                                                    <button type="submit" class="px-2.5 py-1.5 bg-amber-50 hover:bg-amber-100 text-amber-700 font-semibold text-xs rounded-lg transition border border-amber-200" onclick="return confirm('Revoke Google Classroom access for {{ $student->student_email }}?')">
                                                        Unenroll
                                                    </button>
                                                </form>
                                            @endif
                                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" title="Delete record and unenroll from Classroom">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="px-2.5 py-1.5 bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-xs rounded-lg transition border border-red-200" onclick="return confirm('Are you sure you want to completely remove {{ $student->student_email }}? This will also unenroll them from Google Classroom.')">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colSpan="7" class="py-12 text-center text-slate-400">
                                        No free trial students enrolled yet.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if($freeTrialStudents->hasPages())
                    <div class="p-4 border-t border-slate-100 bg-slate-50/50">
                        {{ $freeTrialStudents->appends(['premium_page' => $premiumStudents->currentPage()])->links() }}
                    </div>
                @endif
            </div>
        </div>

    </div>

    {{-- Full Student Details Modal --}}
    <div id="studentDetailsModal" class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 hidden opacity-0 transition-opacity duration-300" onclick="closeStudentModal()">
        <div class="bg-white rounded-3xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border border-slate-200 transform scale-95 transition-transform duration-300" onclick="event.stopPropagation()">
            {{-- Modal Header --}}
            <div class="bg-gradient-to-r from-slate-900 via-indigo-950 to-slate-900 text-white p-6 md:p-8 rounded-t-3xl relative">
                <button type="button" onclick="closeStudentModal()" class="absolute top-6 right-6 w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center text-lg transition font-bold">
                    ✕
                </button>
                <div class="flex items-center gap-2.5 mb-3">
                    <span id="modalPlanBadge" class="px-3.5 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-blue-500 text-white shadow-sm"></span>
                    <span id="modalStatusBadge" class="px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500/20 text-emerald-300 border border-emerald-400/30"></span>
                </div>
                <h3 id="modalStudentName" class="text-2xl md:text-3xl font-black tracking-tight text-white leading-snug"></h3>
                <p id="modalStudentEmail" class="text-blue-200 font-mono text-base font-bold mt-1.5"></p>
            </div>

            {{-- Modal Body Grid --}}
            <div class="p-6 md:p-8 space-y-6 text-base text-slate-800">
                
                {{-- Section 1: Academic & Contact Profile --}}
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4">
                    <h4 class="text-sm font-black uppercase tracking-wider text-slate-700 border-b border-slate-200 pb-2">Academic Profile</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">Enrolled Program</span>
                            <span id="modalCourseTitle" class="font-extrabold text-slate-950 text-base block"></span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">School / Institution</span>
                            <span id="modalSchoolName" class="font-extrabold text-slate-950 text-base block"></span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">Contact Number</span>
                            <span id="modalPhone" class="font-extrabold text-slate-950 font-mono text-base block"></span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">Referral Code Used</span>
                            <span id="modalReferral" class="font-extrabold text-amber-600 text-base block"></span>
                        </div>
                    </div>
                </div>

                {{-- Section 2: Google Classroom & Trial Status --}}
                <div class="bg-blue-50/60 p-6 rounded-2xl border border-blue-200 space-y-4">
                    <h4 class="text-sm font-black uppercase tracking-wider text-blue-900 border-b border-blue-200 pb-2">Google Classroom Integration</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">Classroom Roster Status</span>
                            <span id="modalGclassStatus" class="font-extrabold text-slate-950 text-base block"></span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">Invitation / OAuth ID</span>
                            <span id="modalGclassInviteId" class="font-mono text-sm font-semibold text-slate-800 break-all block"></span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">Trial Expiration Date</span>
                            <span id="modalTrialExpiry" class="font-extrabold text-slate-950 text-base block"></span>
                        </div>
                        <div id="modalExtensionBox" class="hidden bg-purple-100 p-3 rounded-xl border border-purple-300">
                            <span class="block text-sm text-purple-900 font-black">Extension Request Status</span>
                            <span id="modalExtensionText" class="text-sm text-purple-950 font-bold italic mt-1 block"></span>
                        </div>
                    </div>
                </div>

                {{-- Section 3: Financial & Invoice Details --}}
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-200 space-y-4">
                    <h4 class="text-sm font-black uppercase tracking-wider text-slate-700 border-b border-slate-200 pb-2">Transaction & Payment Details</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 items-start">
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">Amount & Payment Channel</span>
                            <div class="flex items-baseline gap-1">
                                <span id="modalAmount" class="font-black text-slate-950 text-xl"></span>
                                <span id="modalChannel" class="text-sm font-bold text-slate-700"></span>
                            </div>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">System Reference UUID</span>
                            <span id="modalReferenceId" class="font-mono text-sm font-semibold text-slate-800 break-all block"></span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">Registration / Enrolled Date</span>
                            <span id="modalCreatedAt" class="font-extrabold text-slate-950 text-base block"></span>
                        </div>
                        <div>
                            <span class="block text-sm font-bold text-slate-600 mb-1">Xendit Invoice Reference</span>
                            <div class="flex items-center flex-wrap gap-2 mt-1">
                                <span id="modalInvoiceId" class="font-mono text-sm font-bold text-slate-900"></span>
                                <a id="modalInvoiceBtn" href="#" target="_blank" class="hidden px-3.5 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold transition shadow-sm">View Invoice ↗</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Modal Footer --}}
            <div class="p-6 bg-slate-100 rounded-b-3xl border-t border-slate-200 flex items-center justify-end">
                <button type="button" onclick="closeStudentModal()" class="px-8 py-3 bg-slate-900 hover:bg-black text-white font-extrabold text-sm rounded-xl transition shadow-lg">
                    Close Details
                </button>
            </div>
        </div>
    </div>

    <script>
        function openStudentModal(rowElem) {
            try {
                const studentData = JSON.parse(rowElem.getAttribute('data-student'));
                const courseTitle = rowElem.getAttribute('data-course-title') || 'Course Details';
                const courseAcronym = rowElem.getAttribute('data-course-acronym') || '';

                // Header
                document.getElementById('modalStudentName').textContent = studentData.student_name || 'N/A';
                document.getElementById('modalStudentEmail').textContent = studentData.student_email || 'N/A';
                
                const planBadge = document.getElementById('modalPlanBadge');
                if (studentData.plan_type === 'premium') {
                    planBadge.textContent = 'Premium Access ⭐';
                    planBadge.className = 'px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-amber-500 text-white shadow-sm';
                } else {
                    planBadge.textContent = '7-Day Free Trial';
                    planBadge.className = 'px-3 py-1 rounded-full text-xs font-black uppercase tracking-wider bg-blue-600 text-white shadow-sm';
                }

                const statusBadge = document.getElementById('modalStatusBadge');
                statusBadge.textContent = (studentData.status || 'Active').toUpperCase();
                if (studentData.status === 'paid' || studentData.is_paid) {
                    statusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-emerald-500 text-white';
                } else if (studentData.status === 'expired') {
                    statusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-red-500 text-white';
                } else {
                    statusBadge.className = 'px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-slate-700 text-white';
                }

                // Profile
                document.getElementById('modalCourseTitle').textContent = courseAcronym ? `${courseAcronym} - ${courseTitle}` : courseTitle;
                document.getElementById('modalSchoolName').textContent = studentData.school_name || 'N/A';
                document.getElementById('modalPhone').textContent = studentData.student_phone || 'N/A';
                document.getElementById('modalReferral').textContent = studentData.referral_code || 'None';

                // Google Classroom
                const gclassStatus = document.getElementById('modalGclassStatus');
                if (studentData.google_classroom_enrolled) {
                    gclassStatus.innerHTML = '<span class="text-blue-600 font-bold">✓ Invitation Sent / Active</span>';
                } else if (studentData.status === 'expired') {
                    gclassStatus.innerHTML = '<span class="text-red-600 font-bold">✕ Access Revoked</span>';
                } else {
                    gclassStatus.innerHTML = '<span class="text-slate-400">Pending Dispatch</span>';
                }
                document.getElementById('modalGclassInviteId').textContent = studentData.google_classroom_invite_id || 'Not generated yet';
                document.getElementById('modalTrialExpiry').textContent = studentData.trial_expires_at ? new Date(studentData.trial_expires_at).toLocaleString() : 'N/A (Unlimited Season)';

                // Extension Box
                const extBox = document.getElementById('modalExtensionBox');
                if (studentData.extension_status && studentData.extension_status !== 'none') {
                    extBox.classList.remove('hidden');
                    document.getElementById('modalExtensionText').textContent = `Status: ${studentData.extension_status.toUpperCase()} (${studentData.extension_days || 3} Days). Reason: "${studentData.extension_reason || 'No reason specified'}"`;
                } else {
                    extBox.classList.add('hidden');
                }

                // Financials
                document.getElementById('modalAmount').textContent = `₱${parseFloat(studentData.amount || 0).toLocaleString('en-US', {minimumFractionDigits: 2})}`;
                document.getElementById('modalChannel').textContent = studentData.payment_channel ? `(${studentData.payment_channel})` : '(GCASH)';
                document.getElementById('modalReferenceId').textContent = studentData.reference_id || 'N/A';
                document.getElementById('modalCreatedAt').textContent = studentData.created_at ? new Date(studentData.created_at).toLocaleString() : 'N/A';
                document.getElementById('modalInvoiceId').textContent = studentData.xendit_invoice_id || 'No Invoice ID';

                const invoiceBtn = document.getElementById('modalInvoiceBtn');
                if (studentData.xendit_invoice_url) {
                    invoiceBtn.href = studentData.xendit_invoice_url;
                    invoiceBtn.classList.remove('hidden');
                } else {
                    invoiceBtn.classList.add('hidden');
                }

                // Show Modal
                const modal = document.getElementById('studentDetailsModal');
                modal.classList.remove('hidden');
                setTimeout(() => {
                    modal.classList.remove('opacity-0');
                    modal.querySelector('.transform').classList.remove('scale-95');
                }, 10);
            } catch (err) {
                console.error("Failed to parse student data:", err);
            }
        }

        function closeStudentModal() {
            const modal = document.getElementById('studentDetailsModal');
            modal.classList.add('opacity-0');
            modal.querySelector('.transform').classList.add('scale-95');
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }
    </script>
@endsection