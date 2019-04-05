@extends('layouts.app')

@section('content')
<div class="container">
  @if(Session::has('admin_message'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Инфо!</strong> {{Session::get('admin_message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  @if(Session::has('error_message'))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Инфо!</strong> {{Session::get('error_message')}}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>
  @endif
  <h2>Администратори</h2>
  <br>
  <table class="table table-striped">
    <caption>Листа свих администратора</caption>
    <thead>
      <tr>
        <th scope="col">Име и презиме</th>
        <th scope="col">Задужење</th>
        <th scope="col">Е-маил</th>
        <th scope="col">Супер Админ</th>
        <th scope="col">Акције</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($admins as $admin)
      <tr>
        <td>{{ $admin->name }}</td>
        <td>{{ $admin->job }}</td>
        <td>{{ $admin->email }}</td>
        <td><a href="{{route('admin.change-admin-status', $admin->id)}}" type="button" class="btn btn-{{$admin->super_admin == 1 ? 'success' : 'warning'}}" name="button">{{$admin->super_admin == 1 ? 'Да' : 'Не'}}</a></td>
        <td>
          <a type="button" class="btn btn-primary" name="button" href="{{route('admin.edit-admin', $admin->id)}}"><i class="fas fa-edit"></i></a>
          <button type="button" class="btn btn-danger" name="button"><i class="fas fa-trash"></i></button>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  {{ $admins->links() }}
</div>
@endsection
