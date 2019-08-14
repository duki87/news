<div class="" id="vote-area">
  <h3>{{$poll[0]->title}}</h3>
  <input type="hidden" name="poll_id" id="poll_id" value="{{$poll[0]->id}}">
  @if($poll[0]->description)
    <p>
      <i>{{$poll[0]->description}}</i>
    </p>
  @endif
  <p class="poll-text d-none" id="vote-thanks">Хвала што сте гласали!</p>
  <ul class="list-group mt-2">
    @foreach($poll[0]->poll_options as $option)
      <li class="list-group-item poll-option" data-option_id="{{$option->id}}">{{$option->option}} <span class="checked float-right d-none"><i class="fas fa-check"></i></span></li>
    @endforeach
  </ul>

  <div class="mt-2">
      <!-- <button type="button" name="vote_btn" id="vote_btn" class="btn btn-outline-secondary poll-btns">Гласај</button> -->
      <button type="button" name="results_btn" id="results_btn" class="btn btn-outline-secondary poll-btns">Резултати</button>
  </div>
</div>

<div class="mt-2 d-none" id="results-area">
  <h3>Резултати анкете</h3>
  <p>{{$poll[0]->title}}</p>
</div>
