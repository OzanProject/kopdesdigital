@extends('layouts.admin')

@section('title', 'Tambah Paket Langganan')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Buat Paket Baru</h3>
    </div>
    <form action="{{ route('subscription-packages.store') }}" method="POST">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nama Paket</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Contoh: Gold Package" value="{{ old('name') }}" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" id="price" placeholder="0" value="{{ old('price') }}" required min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duration_days">Durasi (Hari)</label>
                        <input type="number" name="duration_days" class="form-control" id="duration_days" placeholder="30" value="{{ old('duration_days', 30) }}" required min="1">
                        <small class="text-muted">30 = Bulanan, 365 = Tahunan</small>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="max_members">Batas Jumlah Anggota (Nasabah)</label>
                        <input type="number" name="max_members" class="form-control" id="max_members" placeholder="100" value="{{ old('max_members') }}" required min="0">
                        <small class="text-muted">Isi 0 untuk Unlimited (Tak Terbatas)</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="max_users">Batas Jumlah Admin (Petugas)</label>
                        <input type="number" name="max_users" class="form-control" id="max_users" placeholder="3" value="{{ old('max_users') }}" required min="0">
                        <small class="text-muted">Isi 0 untuk Unlimited (Tak Terbatas)</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-control" id="description" rows="3">{{ old('description') }}</textarea>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" checked>
                <label class="form-check-label" for="is_active">Aktifkan Paket Ini</label>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Paket</button>
            <a href="{{ route('subscription-packages.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
