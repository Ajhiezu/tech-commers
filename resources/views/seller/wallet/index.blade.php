@extends('layouts.seller')

@section('content')
<div class="page-header-neu">
    <div>
        <div class="inline-block badge-green mb-2">KEUANGAN</div>
        <h1 class="page-title-neu">Saldo Penjual</h1>
        <p class="text-sm font-semibold text-gray-500 mt-1">Kelola pendapatan dan penarikan dana toko Anda.</p>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Balance Card -->
    <div class="lg:col-span-1">
        <div class="card-neu bg-neu-black text-white p-6 relative overflow-hidden h-full flex flex-col justify-center" style="box-shadow: 6px 6px 0 #FFE600">
            <!-- Decorative BG -->
            <div class="absolute -right-10 -top-10 w-40 h-40 border-8 border-neu-yellow rounded-full opacity-20 pointer-events-none"></div>
            <div class="absolute -left-5 -bottom-5 w-20 h-20 bg-neu-blue rounded-none opacity-50 rotate-12 pointer-events-none"></div>
            
            <div class="relative z-10">
                <div class="text-xs font-black uppercase tracking-widest text-neu-yellow mb-2">Saldo Tersedia</div>
                <div class="text-4xl md:text-5xl font-black tracking-tighter mb-8 text-white drop-shadow-[2px_2px_0_#0D0D0D]">@rupiah($wallet->balance ?? 0)</div>
                
                <button onclick="document.getElementById('withdraw-modal').classList.remove('hidden')" 
                        class="btn-neu bg-neu-yellow text-neu-black w-full border-neu-black text-sm py-4">
                    💸 TARIK DANA SEKARANG
                </button>
            </div>
        </div>
    </div>
    
    <!-- Stats Cards -->
    <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
        <div class="card-neu flex flex-col justify-center border-l-[8px] border-l-neu-blue">
            <div class="w-12 h-12 bg-neu-blue text-white flex items-center justify-center border-3 border-neu-black mb-4 text-xl" style="box-shadow: 3px 3px 0 #0D0D0D">📈</div>
            <div class="text-xs font-black uppercase tracking-widest text-gray-500 mb-1">Total Pendapatan</div>
            <div class="text-3xl font-black text-neu-black">@rupiah($wallet->total_earned ?? 0)</div>
            <div class="text-[10px] font-bold text-gray-400 uppercase mt-2">Sepanjang Waktu</div>
        </div>
        <div class="card-neu flex flex-col justify-center border-l-[8px] border-l-neu-pink">
            <div class="w-12 h-12 bg-neu-pink text-white flex items-center justify-center border-3 border-neu-black mb-4 text-xl" style="box-shadow: 3px 3px 0 #0D0D0D">🏧</div>
            <div class="text-xs font-black uppercase tracking-widest text-gray-500 mb-1">Total Penarikan</div>
            <div class="text-3xl font-black text-neu-black">@rupiah($wallet->total_withdrawn ?? 0)</div>
            <div class="text-[10px] font-bold text-gray-400 uppercase mt-2">Selesai Diproses</div>
        </div>
    </div>
</div>

<div class="card-neu p-0 overflow-hidden bg-white">
    <div class="p-5 border-b-3 border-neu-black bg-neu-bg flex items-center gap-3">
        <span class="w-8 h-8 bg-neu-black text-neu-yellow flex items-center justify-center border-2 border-neu-black font-black" style="box-shadow: 2px 2px 0 #0D0D0D">📄</span>
        <h3 class="font-black text-lg text-neu-black uppercase tracking-wider">Riwayat Transaksi</h3>
    </div>
    
    <div class="overflow-x-auto">
        <table class="table-neu w-full">
            <thead>
                <tr>
                    <th class="w-1/4">Tanggal & Waktu</th>
                    <th class="w-1/3">Deskripsi</th>
                    <th>Nominal</th>
                    <th>Saldo Akhir</th>
                </tr>
            </thead>
            <tbody>
                @forelse($transactions as $trx)
                <tr>
                    <td>
                        <div class="font-bold text-neu-black">{{ $trx->created_at->format('d M Y') }}</div>
                        <div class="text-xs font-semibold text-gray-500">{{ $trx->created_at->format('H:i') }} WIB</div>
                    </td>
                    <td class="font-bold text-sm text-neu-black">{{ $trx->description }}</td>
                    <td>
                        @if($trx->type === 'credit')
                            <span class="font-black text-neu-green bg-neu-green/10 px-2 py-1 border border-neu-green inline-block">+ @rupiah($trx->amount)</span>
                        @else
                            <span class="font-black text-neu-red bg-neu-red/10 px-2 py-1 border border-neu-red inline-block">- @rupiah($trx->amount)</span>
                        @endif
                    </td>
                    <td class="font-black text-neu-black">@rupiah($trx->balance_after)</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-16 text-center bg-white">
                        <div class="text-5xl mb-4">💸</div>
                        <div class="font-black text-gray-400 uppercase text-sm">Belum ada transaksi di dompet Anda.</div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if($transactions->hasPages())
    <div class="p-5 border-t-3 border-neu-black bg-neu-bg">
        {{ $transactions->links() }}
    </div>
    @endif
</div>

<!-- Modal Penarikan -->
<div id="withdraw-modal" class="fixed inset-0 z-50 hidden bg-neu-black/80 flex items-center justify-center p-4">
    <div class="modal-neu w-full max-w-md bg-white p-0 overflow-hidden relative transform transition-transform duration-300 scale-95" id="withdraw-modal-content">
        <div class="p-5 border-b-3 border-neu-black bg-neu-yellow flex justify-between items-center">
            <h3 class="font-black text-xl uppercase text-neu-black tracking-wider flex items-center gap-2">
                <span class="bg-white px-2 py-0.5 border-2 border-neu-black">🏦</span>
                Tarik Dana
            </h3>
            <button onclick="closeModal()" class="w-8 h-8 flex items-center justify-center border-3 border-neu-black bg-white hover:bg-neu-red hover:text-white transition-colors" style="box-shadow: 2px 2px 0 #0D0D0D">
                <svg class="w-4 h-4 font-black" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <form action="{{ route('seller.wallet.withdraw') }}" method="POST" class="p-6">
            @csrf
            <div class="mb-5">
                <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Nominal Penarikan</label>
                <div class="relative flex items-center">
                    <div class="absolute inset-y-0 left-0 w-12 flex items-center justify-center border-r-3 border-neu-black bg-neu-bg font-black text-sm">
                        Rp
                    </div>
                    <input type="number" name="amount" required min="50000" max="{{ $wallet->balance ?? 0 }}" 
                           class="input-neu pl-16 py-3 font-black text-lg w-full" placeholder="0">
                </div>
                <div class="flex justify-between items-center mt-2">
                    <div class="text-[10px] font-bold text-gray-500 uppercase">Min. Rp 50.000</div>
                    <div class="text-[10px] font-black text-neu-blue uppercase cursor-pointer hover:underline" onclick="document.querySelector('input[name=amount]').value = {{ $wallet->balance ?? 0 }}">Tarik Semua (@rupiah($wallet->balance ?? 0))</div>
                </div>
            </div>
            
            <div class="mb-5">
                <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Bank Tujuan</label>
                <select name="bank_name" class="input-neu py-3 text-sm font-bold uppercase cursor-pointer">
                    <option value="BCA">Bank BCA</option>
                    <option value="Mandiri">Bank Mandiri</option>
                    <option value="BNI">Bank BNI</option>
                    <option value="BRI">Bank BRI</option>
                    <option value="BSI">Bank Syariah Indonesia (BSI)</option>
                </select>
            </div>
            
            <div class="mb-5">
                <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Nomor Rekening</label>
                <input type="text" name="account_number" required placeholder="Contoh: 1234567890" class="input-neu py-3 text-sm font-bold font-mono">
            </div>
            
            <div class="mb-8">
                <label class="block text-xs font-black uppercase tracking-widest text-neu-black mb-2">Nama Pemilik Rekening</label>
                <input type="text" name="account_name" required placeholder="Sesuai buku tabungan" class="input-neu py-3 text-sm font-bold uppercase">
            </div>
            
            <button type="submit" class="btn-neu-primary w-full py-4 text-sm tracking-widest">AJUKAN PENARIKAN</button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Simple animation for modal
    const modal = document.getElementById('withdraw-modal');
    const modalContent = document.getElementById('withdraw-modal-content');
    
    // Override open behavior
    const originalOnclick = document.querySelector('button[onclick="document.getElementById(\'withdraw-modal\').classList.remove(\'hidden\')"]').onclick;
    document.querySelector('button[onclick="document.getElementById(\'withdraw-modal\').classList.remove(\'hidden\')"]').onclick = function(e) {
        e.preventDefault();
        modal.classList.remove('hidden');
        setTimeout(() => {
            modalContent.classList.remove('scale-95');
            modalContent.classList.add('scale-100');
        }, 10);
    };

    function closeModal() {
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');
        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }
    
    // Close when click outside
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>
@endpush
