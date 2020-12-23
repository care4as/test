<template>
    <div class="container">
      <div class="d-flex bg-light engulfingRow" id='' >
        <div class="p-1 m-3 bg-white columOffer" style='' v-for="offer in offers">
          <div class="row m-0 justify-content-center bg-info text-white">
            Vorschläge
          </div>
          <div class="row m-0">
            <div class="col align-self-center">
                Angebot Name {{offer}}
            </div>
            <div class="col-2 p-2 align-self-end">
                <button type="button" class="btn-close m-0 ml" aria-label="Close" @click="deleteOffer(offer)">X</button>
            </div>
          </div>
          <hr>
          <div class="row m-0">
            LTE / D-Netz
          </div>
          <hr>
          <div class="row m-0">
            10 GB
          </div>
          <hr>
          <div class="row m-0 ">
            <button type="button" class="hwbutton" >
              <div class="d-flex align-items-center justify-content-center">
                <i class="fas fa-plus-circle fa-2x"></i>
                Hardware hinzufügen
              </div>
          </button>
          </div>
          <hr>
          <div class="row m-0">
            Grundgebühr: 9,99€
          </div>
          <hr>
          <div class="row m-0">
            <button type="button" class="hwbutton" name="button">  Rabatt hinzufügen</button>
          </div>
          <hr>
          <div class="row m-0">
            24 Monate <br>
            neue Laufzeit bis 19.12.2022
          </div>
          <hr>
          <div class="row m-0">
            Monatliche Kosten <br>
            Grundgebürh: 9,99€
          </div>
          <hr>
        </div>
        <div class="align-self-center">
          <button type="button" class="btn-button1" @click="addOffer()">+</button>
          Neu- und Bestandskundenangebote
        </div>
      </div>
      <div class="modal" tabindex="-1" role="dialog" id="OffersModal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Neukunden oder Bestandskunden</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <select class="" name="" id="offerCategory">
                <option value="">ANF LTE M</option>
                <option value="">ANF LTE S</option>
                <option value="">ANF </option>
              </select>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-primary">Save changes</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </div>


</template>

<style media="screen">
  .engulfingRow
  {
    overflow: scroll;
    width:auto;
  }
  .columOffer
  {
    min-width: 250px;
    background-color: ;
  }
  .btn-button1
  {
    background-color: white;
    border: 2px solid blue;
    color: blue;
    height: 40px;
    width: 40px;
    align-self: center;
  }
  .hwbutton
  {
    background-color: white !important;
    width: 95%;
    height: 50px;
    border: 1px dotted grey;
    border-radius: 15px;
  }
</style>
<script>
    export default {
      data(){
        return{
          test: 2,
          offers: [1,2],
          counter: 2,
        }
      },
        mounted() {
            console.log('Simulator mounted.')
        },
        methods:{
          addOffer(){
            // $('#OffersModal').show()
            this.counter = this.counter+1
            this.offers.push(this.counter)
          },
          deleteOffer(offer){
            // console.log(offer)
            function removeA(arr) {
                var what, a = arguments, L = a.length, ax;
                while (L > 1 && arr.length) {
                    what = a[--L];
                    while ((ax= arr.indexOf(what)) !== -1) {
                        arr.splice(ax, 1);
                    }
                }
                return arr;
            }

            // this.counter = this.counter-1
            removeA(this.offers, offer);
          }
        },
    }
</script>
