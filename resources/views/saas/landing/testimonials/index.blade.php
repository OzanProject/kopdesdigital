@extends('layouts.admin')

@section('title', 'Testimonial Management')

@section('content')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Kelola Testimoni</h3>
        <div class="card-tools">
            <a href="{{ route('landing-testimonials.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Testimoni
            </a>
        </div>
    </div>
    <div class="card-body p-0">
        <table class="table table-striped projects">
            <thead>
                <tr>
                    <th style="width: 1%">No.</th>
                    <th>Avatar</th>
                    <th>Nama</th>
                    <th>Role</th>
                    <th>Rating</th>
                    <th>Konten</th>
                    <th style="width: 20%">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($testimonials as $testimonial)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if($testimonial->avatar)
                        <img alt="Avatar" class="table-avatar" src="{{ asset('storage/' . $testimonial->avatar) }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @else
                        <img alt="Avatar" class="table-avatar" src="{{ asset('adminlte3/dist/img/default-150x150.png') }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover;">
                        @endif
                    </td>
                    <td><b>{{ $testimonial->name }}</b></td>
                    <td>{{ $testimonial->role }}</td>
                    <td>
                        @for($i=1; $i<=5; $i++)
                            <i class="fas fa-star {{ $i <= $testimonial->rating ? 'text-warning' : 'text-gray' }}"></i>
                        @endfor
                    </td>
                    <td>{{ Str::limit($testimonial->content, 50) }}</td>
                    <td class="project-actions text-right">
                        <a class="btn btn-info btn-sm" href="{{ route('landing-testimonials.edit', $testimonial->id) }}">
                            <i class="fas fa-pencil-alt"></i> Edit
                        </a>
                        <form action="{{ route('landing-testimonials.destroy', $testimonial->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus testimoni ini?')">
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
