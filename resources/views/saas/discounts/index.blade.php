@extends('layouts.admin')

@section('title', 'Kelola Diskon')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Daftar Kode Promo</h3>
        <div class="card-tools">
            <a href="{{ route('discounts.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Buat Kode Promo
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Tipe</th>
                        <th>Nilai</th>
                        <th>Masa Berlaku</th>
                        <th>Kuota</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($discounts as $discount)
                    <tr>
                        <td class="font-weight-bold">{{ $discount->code }}</td>
                        <td>
                            <span class="badge badge-{{ $discount->type == 'percent' ? 'info' : 'success' }}">
                                {{ ucfirst($discount->type) }}
                            </span>
                        </td>
                        <td>
                            @if($discount->type == 'percent')
                                {{ $discount->amount }}%
                            @else
                                Rp {{ number_format($discount->amount, 0, ',', '.') }}
                            @endif
                        </td>
                        <td>
                            <small>
                                {{ $discount->valid_from ? $discount->valid_from->format('d M Y') : 'Now' }} - 
                                {{ $discount->valid_until ? $discount->valid_until->format('d M Y') : 'Set' }}
                            </small>
                        </td>
                        <td>
                            {{ $discount->used_count }} / {{ $discount->max_uses ?? '∞' }}
                        </td>
                        <td>
                            <span class="badge badge-{{ $discount->is_active && ($discount->valid_until == null || now()->lte($discount->valid_until)) ? 'success' : 'secondary' }}">
                                {{ $discount->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('discounts.edit', $discount->id) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('discounts.destroy', $discount->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus kode promo ini?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center">Belum ada kode promo.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer clearfix">
        {{ $discounts->links() }}
    </div>
</div>
@endsection
