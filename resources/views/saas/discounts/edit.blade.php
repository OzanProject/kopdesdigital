@extends('layouts.admin')

@section('title', 'Edit Kode Promo')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Edit Kode Promo: {{ $discount->code }}</h3>
    </div>
    <form action="{{ route('discounts.update', $discount->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Kode Promo (Unik)</label>
                        <input type="text" name="code" class="form-control" value="{{ $discount->code }}" required style="text-transform: uppercase;">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Deskripsi</label>
                        <input type="text" name="description" class="form-control" value="{{ $discount->description }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Tipe Potongan</label>
                        <select name="type" class="form-control">
                            <option value="fixed" {{ $discount->type == 'fixed' ? 'selected' : '' }}>Nominal (Rp)</option>
                            <option value="percent" {{ $discount->type == 'percent' ? 'selected' : '' }}>Persentase (%)</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Nilai Potongan</label>
                        <input type="number" name="amount" class="form-control" value="{{ $discount->amount }}" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Berlaku Dari</label>
                        <input type="date" name="valid_from" class="form-control" value="{{ $discount->valid_from ? $discount->valid_from->format('Y-m-d') : '' }}">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Berlaku Sampai</label>
                        <input type="date" name="valid_until" class="form-control" value="{{ $discount->valid_until ? $discount->valid_until->format('Y-m-d') : '' }}">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Batas Penggunaan (Kuota)</label>
                        <input type="number" name="max_uses" class="form-control" value="{{ $discount->max_uses }}" placeholder="Kosongkan jika tidak terbatas">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Status</label>
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="isActive" name="is_active" {{ $discount->is_active ? 'checked' : '' }}>
                            <label class="custom-control-label" for="isActive">Aktif</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('discounts.index') }}" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
@endsection
