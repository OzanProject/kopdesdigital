@extends('layouts.admin')

@section('title', 'FAQ Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola FAQ (Tanya Jawab)</h3>
        <div class="card-tools">
            <a href="{{ route('landing-faqs.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah FAQ
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">No.</th>
                    <th style="width: 30%">Pertanyaan</th>
                    <th style="width: 40%">Jawaban</th>
                    <th>Urutan</th>
                    <th style="width: 20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faqs as $faq)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td><b>{{ $faq->question }}</b></td>
                    <td>{{ Str::limit($faq->answer, 50) }}</td>
                    <td>{{ $faq->order }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('landing-faqs.edit', $faq->id) }}">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <form action="{{ route('landing-faqs.destroy', $faq->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus FAQ ini?')">
                                <i class="fas fa-trash"></i> Hapus
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
