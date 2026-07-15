@extends('layouts.admin')

@section('title', 'Manage Ambassadors & Agents | SG-Review')
@section('header_title', 'Ambassadors & Agents Database')

@section('content')
    <div class="w-full max-w-7xl mx-auto py-6 space-y-10">

        {{-- Top Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h2 class="text-2xl font-bold text-slate-800">Ambassadors & Agents</h2>
                <p class="text-slate-500 text-sm">Monitor registered agents, track student referrals, and audit 10% commission payouts.</p>
            </div>

            <div class="flex items-center gap-3">
                <button onclick="openAddModal()" type="button"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-sm hover:shadow-md flex items-center gap-2 cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                    <span>Add New Agent</span>
                </button>
            </div>
        </div>

        {{-- Alerts --}}
        @if(session('success'))
            <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-xl font-medium text-sm flex items-center justify-between">
                <span>✓ {{ session('success') }}</span>
            </div>
        @endif
        @if ($errors->any())
            <div class="p-4 bg-red-50 border border-red-200 text-red-800 rounded-xl text-sm">
                <span class="font-bold block mb-1">⚠️ Please correct the following errors:</span>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Summary Cards Grid --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Agents</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($agents->count()) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl font-bold">
                    🤝
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Total Referrals</p>
                    <h3 class="text-2xl font-bold text-slate-800 mt-1">{{ number_format($totalReferralsCount ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center text-xl font-bold">
                    👥
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Paid Enrollees</p>
                    <h3 class="text-2xl font-bold text-emerald-600 mt-1">{{ number_format($paidReferralsCount ?? 0) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-xl font-bold">
                    🎓
                </div>
            </div>

            <div class="bg-white rounded-2xl p-5 border border-slate-200 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Estimated Commissions</p>
                    <h3 class="text-2xl font-bold text-amber-600 mt-1">₱{{ number_format($totalCommissionsEarned ?? 0, 2) }}</h3>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-xl font-bold">
                    💰
                </div>
            </div>
        </div>

        {{-- Agents Table --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <h3 class="font-bold text-slate-800 text-sm">Registered Ambassadors List</h3>
                <span class="text-xs text-slate-400 font-medium">{{ $agents->count() }} records found</span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="py-4 px-6">Ambassador & Contact</th>
                            <th class="py-4 px-6">Referral Code</th>
                            <th class="py-4 px-6 text-center">Referrals / Clients</th>
                            <th class="py-4 px-6">10% Commission Earned</th>
                            <th class="py-4 px-6 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse ($agents as $agent)
                            @php
                                $referralsCount = $agent->referrals->count();
                                $paidCount = $agent->referrals->where('is_paid', true)->count();
                                $totalSales = $agent->referrals->where('is_paid', true)->sum('amount');
                                $agentCommission = $totalSales * 0.10;
                            @endphp
                            <tr class="hover:bg-slate-50/80 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="font-bold text-slate-800">{{ $agent->name }}</div>
                                    <div class="text-xs text-slate-500">{{ $agent->email }} | {{ $agent->phone_number }}</div>
                                    @if($agent->facebook_link)
                                        <a href="{{ $agent->facebook_link }}" target="_blank" class="text-xs text-blue-600 hover:underline inline-flex items-center gap-1 mt-0.5">
                                            <span>Facebook Profile</span> ↗
                                        </a>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-lg bg-blue-50 border border-blue-200 text-blue-700 font-mono font-bold text-xs tracking-wider">
                                        {{ $agent->agent_code }}
                                    </span>
                                </td>
                                <td class="py-4 px-6 text-center">
                                    <div class="inline-flex items-center gap-2">
                                        <span class="font-bold {{ $referralsCount > 0 ? 'text-blue-600' : 'text-slate-400' }}">
                                            {{ $referralsCount }} Student{{ $referralsCount !== 1 ? 's' : '' }}
                                        </span>
                                        @if($referralsCount > 0)
                                            <button onclick='openClientsModal({{ json_encode($agent) }}, {{ json_encode($agent->referrals) }})' type="button"
                                                class="text-xs bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold px-2.5 py-1 rounded-md transition cursor-pointer">
                                                View Clients
                                            </button>
                                        @endif
                                    </div>
                                    @if($paidCount > 0)
                                        <div class="text-xs text-emerald-600 font-medium mt-0.5">{{ $paidCount }} Paid Enrollee{{ $paidCount !== 1 ? 's' : '' }}</div>
                                    @endif
                                </td>
                                <td class="py-4 px-6">
                                    <div class="font-bold {{ $agentCommission > 0 ? 'text-amber-600' : 'text-slate-400' }}">
                                        ₱{{ number_format($agentCommission, 2) }}
                                    </div>
                                    <div class="text-xs text-slate-400">from ₱{{ number_format($totalSales, 2) }} total sales</div>
                                </td>
                                <td class="py-4 px-6 text-right space-x-2">
                                    <button onclick='openEditModal({{ json_encode($agent) }})' type="button"
                                        class="inline-flex items-center px-3 py-1.5 rounded-lg bg-blue-50 hover:bg-blue-100 text-blue-600 font-semibold text-xs transition cursor-pointer">
                                        Edit
                                    </button>

                                    <form action="{{ route('agents.destroy', $agent->id) }}" method="POST" class="inline-block delete-agent-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 rounded-lg bg-red-50 hover:bg-red-100 text-red-600 font-semibold text-xs transition cursor-pointer">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-12 text-center text-slate-400 text-sm">
                                    No agents or ambassadors found in the database.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    {{-- ADD AGENT MODAL --}}
    <div id="addAgentModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200">
            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Add New Ambassador / Agent</h3>
                <button onclick="closeAddModal()" type="button" class="text-slate-400 hover:text-slate-600 text-xl font-bold cursor-pointer">×</button>
            </div>

            <form action="{{ route('agents.admin.store') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required placeholder="e.g. Maria Santos"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-medium">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" name="email" required placeholder="maria@example.com"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Contact Number <span class="text-red-500">*</span></label>
                        <input type="text" name="phone_number" required placeholder="0917 123 4567"
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Facebook Profile Link <span class="text-slate-400 font-normal">(Optional)</span></label>
                    <input type="text" name="facebook_link" placeholder="https://facebook.com/mariasantos"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Custom Referral Code <span class="text-slate-400 font-normal">(Optional)</span></label>
                    <input type="text" name="agent_code" placeholder="e.g. MARIA-PRC2026"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-bold uppercase tracking-wider">
                    <p class="text-[11px] text-slate-400 mt-1">Leave blank for automatic unique code generation.</p>
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                    <button onclick="closeAddModal()" type="button" class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-semibold text-sm cursor-pointer">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md cursor-pointer">Save Agent</button>
                </div>
            </form>
        </div>
    </div>

    {{-- EDIT AGENT MODAL --}}
    <div id="editAgentModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-slate-200">
            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                <h3 class="text-lg font-bold text-slate-800">Edit Ambassador Details</h3>
                <button onclick="closeEditModal()" type="button" class="text-slate-400 hover:text-slate-600 text-xl font-bold cursor-pointer">×</button>
            </div>

            <form id="editAgentForm" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Full Name <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_name" name="name" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-medium">
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Email Address <span class="text-red-500">*</span></label>
                        <input type="email" id="edit_email" name="email" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-medium">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Contact Number <span class="text-red-500">*</span></label>
                        <input type="text" id="edit_phone_number" name="phone_number" required
                            class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-medium">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Facebook Profile Link</label>
                    <input type="text" id="edit_facebook_link" name="facebook_link"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-medium">
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Referral Code <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_agent_code" name="agent_code" required
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-600 focus:ring-2 focus:ring-blue-600/20 outline-none text-sm font-bold uppercase tracking-wider">
                </div>

                <div class="pt-4 flex justify-end gap-3 border-t border-slate-100">
                    <button onclick="closeEditModal()" type="button" class="px-5 py-2.5 rounded-xl text-slate-600 hover:bg-slate-100 font-semibold text-sm cursor-pointer">Cancel</button>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-blue-600 hover:bg-blue-700 text-white font-bold text-sm shadow-md cursor-pointer">Update Agent</button>
                </div>
            </form>
        </div>
    </div>

    {{-- VIEW CLIENTS / REFERRALS MODAL --}}
    <div id="clientsModal" class="fixed inset-0 z-50 hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white rounded-3xl max-w-3xl w-full p-6 sm:p-8 shadow-2xl border border-slate-200 max-h-[85vh] flex flex-col">
            <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                <div>
                    <h3 class="text-lg font-bold text-slate-800">Referred Clients by <span id="clientModalAgentName" class="text-blue-600"></span></h3>
                    <p class="text-xs text-slate-500 mt-0.5">Referral Code: <span id="clientModalAgentCode" class="font-mono font-bold text-slate-700"></span></p>
                </div>
                <button onclick="closeClientsModal()" type="button" class="text-slate-400 hover:text-slate-600 text-xl font-bold cursor-pointer">×</button>
            </div>

            <div class="overflow-y-auto flex-1">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-200 text-xs font-bold text-slate-500 uppercase">
                            <th class="py-3 px-4">Student Name</th>
                            <th class="py-3 px-4">Email</th>
                            <th class="py-3 px-4">Plan & Status</th>
                            <th class="py-3 px-4 text-right">Amount Paid</th>
                            <th class="py-3 px-4 text-right">10% Commission</th>
                        </tr>
                    </thead>
                    <tbody id="clientModalTbody" class="divide-y divide-slate-100 text-sm">
                    </tbody>
                </table>
            </div>

            <div class="pt-4 mt-4 border-t border-slate-100 flex justify-end">
                <button onclick="closeClientsModal()" type="button" class="px-5 py-2 rounded-xl bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-sm cursor-pointer">Close</button>
            </div>
        </div>
    </div>

    <script>
        function openAddModal() {
            const modal = document.getElementById('addAgentModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeAddModal() {
            const modal = document.getElementById('addAgentModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function openEditModal(agent) {
            const form = document.getElementById('editAgentForm');
            if (form) form.action = `/admin/agents/${agent.id}`;

            document.getElementById('edit_name').value = agent.name || '';
            document.getElementById('edit_email').value = agent.email || '';
            document.getElementById('edit_phone_number').value = agent.phone_number || '';
            document.getElementById('edit_facebook_link').value = agent.facebook_link || '';
            document.getElementById('edit_agent_code').value = agent.agent_code || '';

            const modal = document.getElementById('editAgentModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeEditModal() {
            const modal = document.getElementById('editAgentModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        function openClientsModal(agent, referrals) {
            document.getElementById('clientModalAgentName').textContent = agent.name || '';
            document.getElementById('clientModalAgentCode').textContent = agent.agent_code || '';

            const tbody = document.getElementById('clientModalTbody');
            tbody.innerHTML = '';

            if (!referrals || referrals.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="py-8 text-center text-slate-400 text-sm">No referred students found for this code yet.</td></tr>`;
            } else {
                referrals.forEach(client => {
                    const isPaid = client.is_paid || client.status === 'paid' || client.status === 'active';
                    const amount = Number(client.amount || 0);
                    const commission = isPaid ? amount * 0.10 : 0;

                    const planClass = client.plan_type === 'premium' ? 'bg-blue-100 text-blue-800' : 'bg-slate-100 text-slate-700';
                    const statusClass = isPaid ? 'text-emerald-600' : 'text-amber-600';

                    const row = document.createElement('tr');
                    row.className = 'hover:bg-slate-50';
                    row.innerHTML = `
                        <td class="py-3 px-4 font-bold text-slate-800">${client.student_name || ''}</td>
                        <td class="py-3 px-4 text-slate-500 text-xs">${client.student_email || ''}</td>
                        <td class="py-3 px-4">
                            <span class="px-2 py-0.5 rounded text-[11px] font-bold uppercase ${planClass}">${client.plan_type || ''}</span>
                            <span class="ml-1 text-xs font-semibold ${statusClass}">${client.status || ''}</span>
                        </td>
                        <td class="py-3 px-4 text-right font-medium text-slate-700">₱${amount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                        <td class="py-3 px-4 text-right font-bold text-amber-600">₱${commission.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                    `;
                    tbody.appendChild(row);
                });
            }

            const modal = document.getElementById('clientsModal');
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        }

        function closeClientsModal() {
            const modal = document.getElementById('clientsModal');
            if (modal) {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
            }
        }

        // Close modal when clicking outside on the backdrop
        window.addEventListener('click', function(e) {
            const addModal = document.getElementById('addAgentModal');
            const editModal = document.getElementById('editAgentModal');
            const clientsModal = document.getElementById('clientsModal');

            if (e.target === addModal) closeAddModal();
            if (e.target === editModal) closeEditModal();
            if (e.target === clientsModal) closeClientsModal();
        });

        // SweetAlert Delete Confirmation matching reviewer.blade.php
        document.querySelectorAll('.delete-agent-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Delete Ambassador?',
                    text: "Are you sure you want to delete this agent? This cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#64748b',
                    confirmButtonText: 'Yes, delete!',
                    cancelButtonText: 'Cancel',
                    customClass: {
                        popup: 'bg-white rounded-2xl shadow-xl border border-slate-200',
                        title: 'text-slate-800 font-bold',
                        htmlContainer: 'text-slate-500 text-sm'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endsection
