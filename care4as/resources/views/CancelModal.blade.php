<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h2 class="">Cancelgrund</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="row ">
          <div class="col text-center text-white bg-light" style="border-radius: 15px;">
            <form class="w-50  text-dark p-4" action="{{route('cancels.save')}}" method="post" style="margin-left: 25%;">
              @csrf
              <div class="form-group text-dark">
                <label for="case">Case ID</label>
                <input type="text" class="form-control" name="case" id="case" aria-describedby="case" Placeholder="z.B. 90191910">
              </div>
              <div class="form-group">
                <label for="offer">Angebot</label>
                <input type="text" class="form-control" id="Offer" name="Offer" aria-describedby="offer" Placeholder="z.B. ANF zu xx,xx€">
              </div>
              <div class="form-group">
                <label for="exampleFormControlSelect1">Kategorie</label>
                   <select class="form-control" id="exampleFormControlSelect1">
                     <option>Fehlrouting</option>
                     <option>Negativflag</option>
                     <option>Angebot zu teuer</option>
                     <option>zuwenig DV</option>
                     <option>lange Laufzeiten</option>
                     <option>DSL Kunde</option>
                   </select>
                 </div>
              <div class="form-group">
                <label for="cause">Cancelgrund</label>
                <textarea class="form-control" name="Cause" id="cause" rows="3" Placeholder="bitte hier eingeben..."></textarea>
              </div>
              <button type="submit" class="btn btn-primary">Daten absenden</button>
              </form>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
