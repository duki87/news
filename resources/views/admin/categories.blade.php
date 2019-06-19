@extends('layouts.app')

@section('content')
<div class="container">
  <div class="" id="ajax_message">

  </div>
  @if(Session::has('cat_message'))
  <div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Инфо!</strong> {{Session::get('cat_message')}}
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
  <h2 class="d-inline">Категорије (Рубрике)</h2> <a type="button" name="button" class="btn btn-primary text-white d-inline float-right mb-2" data-toggle="modal" data-target="#addCatModal">Додај категорију</a>
  <br>
  <table class="table table-striped">
    <caption>Листа свих категорија</caption>
    <thead>
      <tr>
        <th scope="col">Назив</th>
        <th class="text-center">Подкатегорија зa</th>
        <th class="text-center">Урл категорије</th>
        <th class="text-center">Акције</th>
      </tr>
    </thead>
    <tbody id="catData">
      @foreach ($categories as $category)
      <tr>
        <td>{{ $category->title }}</td>
        <td class="text-center">{{ $category->parent == 0 ? 'Главна категорија' : App\Http\Controllers\CategoryController::parent_name($category->parent) }}</td>
        <td class="text-center">{{ $category->url }}</td>
        <td class="text-center">
          <a type="button" class="btn btn-primary edit text-white" id="{{ $category->id }}" name="button" data-toggle="modal" data-target="#editCatModal"><i class="fas fa-edit"></i></a>
          <a type="button" class="btn btn-danger" name="button" onclick="return confirm('Да ли сте сигурни да желите да обришете ову категорију?')" href="{{route('admin.remove-category', $category->id)}}"><i class="fas fa-trash"></i></a>
        </td>
      </tr>
      @endforeach
    </tbody>
  </table>
  <div id="links">
    {{ $categories->links() }}
  </div>


  <!-- ADD Modal -->
  <div class="modal" id="addCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="" id="addCat" novalidate>
          @csrf
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Додај категорију (рубрику)</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="title">Назив категорије</label>
              <input type="text" class="form-control" id="title" name="title" placeholder="Назив категорије" value="" required>
            </div>
            <div class="form-group mt-2">
              <label for="parent">Главна категорија (ако се не изабере, категорије ће бити третирана као главна категорија)</label>
              <select class="custom-select" id="parent" name="parent">
                <option value="" selected>Изаберите</option>
                @foreach($parents as $parent)
                  <option value="{{$parent->id}}">{{$parent->title}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="url">Урл категорије</label>
              <input type="text" class="form-control" id="url" name="url" placeholder="Урл категорије" value="" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Сачувај</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- EDIT Modal -->
  <div class="modal" id="editCatModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form class="" id="editCat" action="{{route('admin.update-category')}}" method="POST">
          @csrf
          <input type="hidden" name="id" id="cat_id" value="">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLongTitle">Измени категорију (рубрику) <strong id="cat_ttl"></strong> </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="title">Назив категорије</label>
              <input type="text" class="form-control" id="edit_title" name="edit_title" placeholder="Назив категорије" value="" required>
            </div>
            <div class="form-group mt-2" id="selectParent">
              <label for="parent">Главна категорија (ако се не изабере, категорије ће бити третирана као главна категорија)</label>
              <select class="custom-select" id="edit_parent" name="edit_parent">
                <option value="0">Главна категорија</option>
                @foreach($parents as $parent)
                  <option value="{{$parent->id}}">{{$parent->title}}</option>
                @endforeach
              </select>
            </div>
            <div class="form-group">
              <label for="url">Урл категорије</label>
              <input type="text" class="form-control" id="edit_url" name="edit_url" placeholder="Урл категорије" value="" required>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Сачувај измене</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection

@section('custom-js')
<script type="text/javascript" src="{{asset('js/categories.js')}}"></script>
@endsection
