<footer class="main-footer border-top-0 shadow-sm bg-white py-3">
    <div class="container-fluid">
        <div class="row align-items-center">
            {{-- Bagian Kiri: Copyright --}}
            <div class="col-md-6 text-center text-md-left mb-2 mb-md-0">
                <span class="text-muted small">
                    <strong>Copyright &copy; {{ date('Y') }}</strong> 
                    <span class="text-primary font-weight-bold ml-1">
                        {{ auth()->user()->hasRole('super_admin') 
                            ? (\App\Models\SaasSetting::where('key', 'app_name')->value('value') ?? config('app.name'))
                            : ($koperasi->nama ?? config('app.name')) 
                        }}
                    </span>
                    <span class="d-none d-lg-inline ml-1 text-secondary">| Dashboard Management.</span>
                </span>
            </div>

            {{-- Bagian Kanan: Version & Support Links --}}
            <div class="col-md-6 text-center text-md-right">
                <ul class="list-inline mb-0">
                    <li class="list-inline-item mr-3">
                        <a href="{{ route('knowledge-base.index') }}" class="text-muted small font-weight-bold">
                            <i class="fas fa-book-reader mr-1"></i> Bantuan
                        </a>
                    </li>
                    <li class="list-inline-item mr-3">
                        <a href="{{ route('landing.terms') }}" target="_blank" class="text-muted small">Ketentuan</a>
                    </li>
                    <li class="list-inline-item">
                        <span class="badge badge-light border text-muted px-2 py-1" style="font-size: 0.7rem;">
                            <i class="fas fa-code-branch mr-1"></i> 
                            v{{ \App\Models\SaasSetting::where('key', 'app_version')->value('value') ?? '1.2.4' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>

<style>
    .main-footer {
        font-family: 'Inter', sans-serif;
        background: #fff;
    }
    .main-footer a:hover {
        color: #0d6efd !important;
        text-decoration: none;
    }
    .badge-light {
        background-color: #f8fafc;
    }
</style>