@extends('layouts.app')

@section('content')
<div class="container">
  <div class="row justify-content-center">
      <div class="col-md-8">
        @if(Session::has('admin_message_err'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
          <strong>Инфо!</strong> {{Session::get('admin_message_err')}}.
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        @endif
        <form action="{{route('admin.store-admin')}}" method="post">
          @csrf
            <div class="card">
                <div class="card-header">
                  <strong>Додај корисника</strong>
                </div>
                <div class="card-body">
                  <div class="form-group">
                    <label for="formGroupExampleInput">Име и презиме</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Име и презиме" required>
                  </div>
                  <div class="form-group">
                    <label for="formGroupExampleInput2">Е-маил</label>
                    <input type="text" class="form-control" id="email" name="email" placeholder="Е-маил" required>
                  </div>
                  <div class="form-group">
                    <label for="formGroupExampleInput2">Изаберите занимање</label>
                    <select class="custom-select custom-select-lg mb-3" name="job" id="job" required>
                      <option selected>Изаберите</option>
                      <option value="journalist">Новинар</option>
                      <option value="editor">Уредник</option>
                      <option value="director">Директор</option>
                      <option value="marketing">Маркетинг</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" class="custom-control-input" name="super_admin" id="super_admin">
                      <label class="custom-control-label" for="super_admin">Супер админ</label>
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-success" name="button">Додај корисника</button>
                  </div>
                </div>
            </div>
          </form>
      </div>
  </div>
</div>
@endsection
