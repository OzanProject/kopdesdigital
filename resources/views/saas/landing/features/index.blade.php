@extends('layouts.admin')

@section('title', 'Fitur Unggulan')

@section('content')
<div class="card">
    <div class="card-header">
        <div class="d-flex flex-wrap justify-content-between align-items-center">
            <h3 class="card-title mb-2 mb-md-0">Kelola Fitur Unggulan</h3>
            <div class="card-tools ml-auto">
                <a href="{{ route('landing-features.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Fitur
                </a>
            </div>
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-striped projects">
                <thead>
                    <tr>
                        <th style="width: 1%">No.</th>
                        <th style="width: 20%">Judul</th>
                        <th style="width: 30%">Deskripsi</th>
                        <th>Icon Class</th>
                        <th>Urutan</th>
                        <th style="width: 20%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($features as $feature)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><b>{{ $feature->title }}</b></td>
                        <td>{{ Str::limit($feature->description, 50) }}</td>
                        <td><code>{{ $feature->icon }}</code></td>
                        <td>{{ $feature->order }}</td>
                        <td class="project-actions text-right">
                            <a class="btn btn-info btn-sm" href="{{ route('landing-features.edit', $feature->id) }}">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <form action="{{ route('landing-features.destroy', $feature->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus fitur ini?')">
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
</div>
@endsection
