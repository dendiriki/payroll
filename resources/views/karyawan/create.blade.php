@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h3>Tambah Karyawan</h3>

    @if ($errors->any())
      <div class="alert alert-danger">
        <ul class="mb-0">
          @foreach ($errors->all() as $err) <li>{{ $err }}</li> @endforeach
        </ul>
      </div>
    @endif

    <form action="{{ route('karyawan.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Akun User <span class="text-danger">*</span></label>
            <select name="user_id" class="form-control" required>
                <option value="">-- Pilih user --</option>
                @foreach($users as $u)
                    <option value="{{ $u->id }}" {{ old('user_id') == $u->id ? 'selected' : '' }}>
                        {{ $u->name }} ({{ $u->email }})
                    </option>
                @endforeach
            </select>
            <small class="text-muted">Harap isi user yang sudah di register.</small>
        </div>

        <div class="mb-3">
            <label>Nama Lengkap</label>
            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}" required>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label>Tempat Lahir</label>
                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
            </div>
            <div class="col-md-4 mb-3">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" class="form-control">
                    <option value="">-- Pilih --</option>
                    <option value="L" {{ old('jenis_kelamin')=='L'?'selected':'' }}>Laki-laki</option>
                    <option value="P" {{ old('jenis_kelamin')=='P'?'selected':'' }}>Perempuan</option>
                </select>
            </div>
        </div>

        <div class="mb-3">
            <label>Jabatan</label>
            <input type="text" name="jabatan" class="form-control" value="{{ old('jabatan') }}">
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Status</label>
                <select name="status" class="form-control" required>
                    <option value="Tetap" {{ old('status')=='Tetap'?'selected':'' }}>Tetap</option>
                    <option value="Kontrak" {{ old('status')=='Kontrak'?'selected':'' }}>Kontrak</option>
                    <option value="HL" {{ old('status')=='HL'?'selected':'' }}>HL</option>
                </select>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tanggal Bergabung</label> <!-- ✅ join_date -->
                <input type="date" name="join_date" class="form-control" value="{{ old('join_date') }}" required>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label>Gaji Pokok</label>
                <input type="number" name="gaji_pokok" class="form-control" value="{{ old('gaji_pokok') }}" required>
            </div>
            <div class="col-md-6 mb-3">
                <label>Tunjangan</label>
                <input type="number" name="tunjangan" class="form-control" value="{{ old('tunjangan',0) }}">
            </div>
        </div>

        <div class="form-check mb-3">
            <input type="checkbox" name="bpjs" value="1" class="form-check-input" id="bpjs" {{ old('bpjs') ? 'checked' : '' }}>
            <label class="form-check-label" for="bpjs">Dapat potongan BPJS</label>
        </div>

        <button class="btn btn-success">Simpan</button>
        <a href="{{ route('karyawan.index') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
