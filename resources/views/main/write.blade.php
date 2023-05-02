@extends('layout.main_write')

@section('content')
<div class="col-md-8 col-sm-12 bg-white p-4">
  <form method="post" action="">
    @csrf
    <div class="form-group">
      <label>Judul Artikel</label>
      <input type="text" class="form-control" name="judul" placeholder="Judul artikel">
    </div>
    <div class="form-group">
      <label>Isi Artikel</label>
      <textarea class="form-control" name="deskripsi" rows="10"></textarea>
    </div>

</div>
</form>
@endsection