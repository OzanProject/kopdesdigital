@extends('layouts.admin')

@section('title', 'Edit Paket Langganan')

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Edit Paket: {{ $subscriptionPackage->name }}</h3>
    </div>
    <form action="{{ route('subscription-packages.update', $subscriptionPackage->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="form-group">
                <label for="name">Nama Paket</label>
                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $subscriptionPackage->name) }}" required>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="price">Harga (Rp)</label>
                        <input type="number" name="price" class="form-control" id="price" value="{{ old('price', $subscriptionPackage->price) }}" required min="0">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="duration_days">Durasi (Hari)</label>
                        <input type="number" name="duration_days" class="form-control" id="duration_days" value="{{ old('duration_days', $subscriptionPackage->duration_days) }}" required min="1">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="max_members">Batas Jumlah Anggota (Nasabah)</label>
                        <input type="number" name="max_members" class="form-control" id="max_members" value="{{ old('max_members', $subscriptionPackage->max_members) }}" required min="0">
                        <small class="text-muted">Isi 0 untuk Unlimited (Tak Terbatas)</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="max_users">Batas Jumlah Admin (Petugas)</label>
                        <input type="number" name="max_users" class="form-control" id="max_users" value="{{ old('max_users', $subscriptionPackage->max_users) }}" required min="0">
                        <small class="text-muted">Isi 0 untuk Unlimited (Tak Terbatas)</small>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea name="description" class="form-control" id="description" rows="3">{{ old('description', $subscriptionPackage->description) }}</textarea>
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" {{ $subscriptionPackage->is_active ? 'checked' : '' }}>
                <label class="form-check-label" for="is_active">Aktifkan Paket Ini</label>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('subscription-packages.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
