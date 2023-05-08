@extends('layout.main')
@section('title', 'Notification')

@section('content')
<body>
  <div class="container mt-5">
    <div class="row">
      <div class="col-12">
        <h2>Notifications</h2>
        <div class="notification-options mt-3">
          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            <label class="btn btn-outline-primary active">
              <input type="radio" name="options" id="all" autocomplete="off" checked> All
            </label>
            <label class="btn btn-outline-primary">
              <input type="radio" name="options" id="responses" autocomplete="off"> Responses
            </label>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
@endsection