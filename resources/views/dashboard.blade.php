<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @php
                        $koperasi = Auth::user()->koperasi;
                    @endphp

                    <h3 class="text-lg font-bold mb-4">Selamat Datang, {{ Auth::user()->name }}!</h3>

                    @if($koperasi)
                        <div class="mb-4">
                            <p class="text-gray-600 dark:text-gray-400">Institusi: <strong>{{ $koperasi->name }}</strong></p>
                            <p class="text-gray-600 dark:text-gray-400">Status: 
                                <span class="px-2 py-1 rounded text-white {{ $koperasi->status == 'active' ? 'bg-green-500' : 'bg-yellow-500' }}">
                                    {{ ucfirst(str_replace('_', ' ', $koperasi->status)) }}
                                </span>
                            </p>
                        </div>

                        @if($koperasi->status == 'pending_payment')
                            <div class="bg-yellow-100 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-4" role="alert">
                                <p class="font-bold">Pembayaran Tertunda</p>
                                <p>Silakan selesaikan pembayaran untuk mengaktifkan layanan penuh.</p>
                            </div>
                            <a href="{{ route('subscription.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:bg-blue-500 active:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition ease-in-out duration-150">
                                Kelola Langganan / Bayar
                            </a>
                        @else
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <a href="{{ route('admin.dashboard') }}" class="block p-6 bg-indigo-50 dark:bg-indigo-900 border border-indigo-200 dark:border-indigo-700 rounded-lg hover:shadow-md transition">
                                    <h5 class="mb-2 text-xl font-bold tracking-tight text-indigo-900 dark:text-indigo-100">Masuk ke Panel Admin</h5>
                                    <p class="font-normal text-indigo-700 dark:text-indigo-300">Kelola data anggota, simpanan, dan pinjaman.</p>
                                </a>
                            </div>
                        @endif
                    @else
                        <p>Anda belum terhubung dengan Koperasi manapun.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
