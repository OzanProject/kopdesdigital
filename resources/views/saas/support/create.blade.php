@extends('layouts.admin')

@section('title', 'Buat Tiket Baru')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Formulir Tiket Bantuan</h3>
            </div>
            <form action="{{ route('support.store') }}" method="POST">
                @csrf
                <div class="card-body">
                    <div class="form-group">
                        <label for="subject">Subjek Masalah</label>
                        <input type="text" name="subject" class="form-control" id="subject" placeholder="Contoh: Error saat input transaksi..." required>
                    </div>
                    
                    <div class="form-group">
                        <label for="priority">Prioritas</label>
                        <select name="priority" class="form-control" id="priority">
                            <option value="low">Rendah (Pertanyaan Umum)</option>
                            <option value="medium" selected>Sedang (Masalah Teknis Ringan)</option>
                            <option value="high">Tinggi (Fitur Tidak Berjalan)</option>
                            <option value="critical">Kritis (Sistem Down / Data Hilang)</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Deskripsi Masalah</label>
                        <textarea name="message" class="form-control" rows="5" placeholder="Jelaskan masalah Anda sedetail mungkin..." required></textarea>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Kirim Tiket</button>
                    <a href="{{ route('support.index') }}" class="btn btn-default float-right">Batal</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
