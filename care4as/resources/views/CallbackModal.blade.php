<div class="modal fade" id="redirectModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h2 class="">Weiterleitung</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col text-center text-white bg-light" style="border-radius: 15px;">
            <form class="w-50  text-dark p-4" action="{{route('callback.save')}}" method="post" style="margin-left: 25%;">
              @csrf
              <div class="form-group text-dark">
                <label for="customer">Kundennummmer</label>
                <input type="text" class="form-control" name="customer" id="customer" aria-describedby="case" Placeholder="z.B. 2473231">
              </div>
              <div class="form-group">
                <label for="time">Rückruf zu</label>
                <input type="text" class="form-control" id="time" name="time" aria-describedby="offer" Placeholder="z.B. von 14 -15 Uhr">
              </div>
              <div class="form-group">
                <label for="cause">Was wurde besprochen?</label>
                <textarea class="form-control" name="cause" id="cause" rows="3" Placeholder="bitte hier eingeben..."></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Weiterleiten</button>
              </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
