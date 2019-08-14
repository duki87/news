@extends('layouts.app')

@section('content')
<div class="container">
  <div class="" id="news_message">

  </div>
  @if(Session::has('session_message'))
    <div class="alert alert-{{Session::get('session_message.alert')}} alert-dismissible fade show" role="alert">
      <strong>ИНФО</strong>{{Session::get('session_message.content')}}
      <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
  @endif
  @if(count($errors))
  <div class="alert alert-danger alert-dismissible fade show" role="alert">
     <ul class="">
       @foreach($errors->all() as $error)
          <li>{{$error}}</li>
        @endforeach
     </ul>
     <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
     </button>
   </div>
  @endif
  <h2 class="d-inline">Додај нову анкету</h2> <a href="{{route('admin.all-polls')}}" type="button" name="button" class="btn btn-primary text-white d-inline float-right mb-2">Погледај све вести</a>
  <br>
  <form id="add-news" method="POST" action="{{route('admin.create-poll')}}">
    @csrf
    <div class="form-row mt-3">
      <div class="col-md-6 mb-3">
        <label for="validationDefault01">Наслов</label>
        <input type="text" class="form-control" id="title" name="title" placeholder="Унесите наслов вести">
      </div>
      <div class="col-md-2 mb-3">
        <label for="duration">Трајање анкете (у данима)</label>
        <select class="form-control" name="duration" id="duration">
            <option value="1">1</option>
            <option value="2">2</option>
            <option value="3">3</option>
            <option value="4">4</option>
            <option value="5">5</option>
            <option value="6">6</option>
            <option value="7">7</option>
        </select>
      </div>
      <div class="col-md-3 mb-3">
        <label for="news">Везано за вест (није обавезно)</label>
        <input type="text" class="form-control" disabled value="Није одабрана ниједна вест" id="news_title">
        <input type="hidden" id="news" name="news" value="">
      </div>
      <div class="col-md-1 mb-3" id="btnDiv">
        <label for="news" style="visibility:hidden">sfds</label>
        <button data-toggle="modal" data-target="#newsModal" type="button" name="choose" id="choose" class="text-white btn btn-info">Изаберите вест</button>
        <button type="button" name="deleteBtn" id="deleteBtn" class="text-white btn btn-danger d-none">Одбаци</button>
      </div>
      <div class="col-md-12 mb-3">
        <label for="description">Опис анкете</label>
        <textarea id="description" class="form-control" name="description"></textarea>
      </div>
    </div>
    <hr>
    <h5 class="d-inline">Опције за гласање</h5>
    <br>
    <div class="row">
      <div class="col-md-11 mb-3">
        <label for="add_option" style="visibility:hidden">sfds</label>
        <input class="form-control" type="text" name="" id="add_poll_option" value="">
      </div>
      <div class="col-md-1 mb-3">
        <label for="add" style="visibility:hidden">sfds</label>
        <button type="button" name="add" id="add_option" class="text-white btn btn-info">Додај опцију</button>
      </div>
      <div class="col-md-12">
        <div class="border mt-2 p-4" style="height:10em;" id="options_list">

        </div>
      </div>
    </div>

    <button class="btn btn-primary mt-3" type="submit">Објави анкету</button>
  </form>
</div>

<!-- News Modal -->
<div class="modal fade" id="newsModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Изаберите вест</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div id="categories">
          <label for="category">Категорија</label>
          <select class="form-control" name="category" id="category">
              <?php echo($categories);?>
          </select>
        </div>
        <div id="category_news" class="d-none mt-2">
          <label for="category">Вест</label>
          <select class="form-control" name="news_by_category" id="news_by_category">

          </select>
        </div>
      </div>
      <div class="modal-footer">
        <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Затвори</button>
        <button id="save" type="button" class="btn btn-primary" data-dismiss="modal">Изаберите</button>
      </div>
    </div>
  </div>
</div>
@endsection

@section('custom-js')
  <script type="text/javascript" src="{{asset('js/add-poll.js')}}"></script>
@endsection
