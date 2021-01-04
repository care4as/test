<template>
    <div class="container">
      <div class="d-flex bg-light engulfingRow" id='' >
        <div class="p-1 m-3 bg-white columOffer" style='' v-for="offer in offers">
          <div class="row m-0 justify-content-center bg-info text-white">
            Vorschläge
          </div>
          <div class="row m-0">
            <div class="col align-self-center">
                {{offer.name}}
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
            {{offer.volume}} GB
          </div>
          <hr>
          <div class="row m-0 ">
            <button type="button" class="hwbutton" @click="openHWModal()">
              <div class="d-flex align-items-center justify-content-center" >
                <i class="fas fa-plus-circle fa-2x"></i>
                Hardware hinzufügen
              </div>
          </button>
          </div>
          <hr>
          <div class="row m-0">
            {{offer.price}} €
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
            Grundgebühr: {{offer.price}}
          </div>
          <hr>
        </div>
        <div class="align-self-center">
          <button type="button" class="btn-button1" data-toggle="modal" data-target=".bd-example-modal-xl">+</button>
          Neu- und Bestandskundenangebote
        </div>
      </div>
      <!-- the modal which initialises an offer -->
      <div class="modal bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="OffersModal" aria-hidden="true" id="OffersModal">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content p-1">
            <div class="titel">
              <h5>Weitere Angebote <button type="button" class="close" data-dismiss="modal" @click="destroyModal('OffersModal')">
                <span aria-hidden="true">&times;</span>
              </button></h5>
              <p>Hier können Sie ein alternatives Angebot auswählen</p>
            </div>
            <div class="auswahl">
              <div class="subauswahl aktiv" @click="setActive('NK')">
                Neukundenangebote
              </div>
              <div class="subauswahl text-break" @click="setActive('BK')">
                Bestandskundenangebote
              </div>
              <div class="subauswahl"  @click="setActive('Special')">
                Spezialangebote
              </div>
              <div class="subauswahl"  @click="setActive('Cyber')">
                Cyberangebote
              </div>
              <div class="subauswahl"  @click="setActive('Beginner')">
                Einsteigerangebote
              </div>
            </div>

            <div class="inhalt">
              <div class="ueberschriften">
                <div class="radio">
                </div>
                <div class="element_1">
                  <b>Tarif</b>
                </div>
                <div class="element">
                  <b>Datenvolumen</b>
                </div>
                <div class="element">
                  <b>Telefonie</b>
                </div>
                <div class="element">
                  <b>Monatlich</b>
                </div>
              </div>
              <div class="tarife" v-for="offer in offers2"  @click="getOffer(offer.id)">
                <div class="radio">
                  <label for="flexRadioDefault1"></label>
                  <input type="radio" name="flexRadioDefault" id="flexRadioDefault1">
                </div>
                <div class="element_1">
                    {{offer.name}}
                </div>
                <div class="element">
                    {{offer.volume}} GB
                </div>
                <div class="element">
                    {{offer.telefon}}
                </div>
                <div class="element">
                  <b>  {{offer.price}} €</b>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="modal bd-example-modal-xl" tabindex="-1" role="dialog" aria-labelledby="OffersModal" aria-hidden="true" id="HWModal">
        <div class="modal-dialog modal-xl" role="document">
          <div class="modal-content">
            <div class="titelleiste ml-3">
            <h5>Hardware hinzufügen</h5>
            <p>Wie empfehlen dem Kunden diese Geräte, basierend auf dem zuletzt gekauften [zuletzt gekauftes Gerät].</p>
        </div>

        <div class="cards">
            <div class="card-simulator">
                <div class="maincard">
                    <div class="titel_card">
                        Empfehlung
                    </div>
                    <div class="name_card">
                        Samsung Galaxy S20+
                    </div>
                    <div class="bild_card">
                        <img src="/images/1.png" alt="">
                    </div>
                    <div class="key_card">
                        Cosmic Black <br>
                        120GB
                    </div>
                    <div class="box_card">
                        <div class="box_card_inside">
                            <div class="box_card_inside_element_u">Einmalig</div>
                            <div class="box_card_inside_element_g">0,00 €</div>
                            <div class="box_card_inside_element_u">1. - 10. Monat</div>
                            <div class="box_card_inside_element_g">49,99 €</div>
                            <div class="box_card_inside_element">danach 54,99 €</div>

                        </div>
                    </div>
                    <div class="infobox_card">
                        - Großes 6,7 Zoll hochauflösendes AMOLED Display <br>
                        - Flüssigste Bilddarstellung dank 120 Hz Display <br>
                        - Hochaufklösende 64 MP 3-Fach Kamera mit 30x Zoom und 8k Videoaufnahmes
                    </div>
                </div>
                <div class="subcard">
                    + vergleichen
                </div>
            </div>
            <div class="card-simulator">
                <div class="maincard">
                    <div class="titel_card">
                        Sehr gute Alternative
                    </div>
                    <div class="name_card">
                        Samsung Galaxy S20+
                    </div>
                    <div class="bild_card">
                        <img src="/images/1.png" alt="">
                    </div>
                    <div class="key_card">
                        Cosmic Black <br>
                        120GB
                    </div>
                    <div class="box_card">
                        <div class="box_card_inside">
                            <div class="box_card_inside_element_u">Einmalig</div>
                            <div class="box_card_inside_element_g">0,00 €</div>
                            <div class="box_card_inside_element_u">1. - 10. Monat</div>
                            <div class="box_card_inside_element_g">49,99 €</div>
                            <div class="box_card_inside_element">danach 54,99 €</div>
                        </div>
                    </div>
                    <div class="infobox_card">
                        - Großes 6,7 Zoll hochauflösendes AMOLED Display <br>
                        - Flüssigste Bilddarstellung dank 120 Hz Display <br>
                        - Hochaufklösende 64 MP 3-Fach Kamera mit 30x Zoom und 8k Videoaufnahmes
                    </div>
                </div>
                <div class="subcard">
                    + vergleichen
                </div>
            </div>

            <div class="card-simulator">
                <div class="maincard">
                    <div class="titel_card ">
                        High-End Empfehlung
                    </div>
                    <div class="name_card">
                        Samsung Galaxy S20+
                    </div>
                    <div class="bild_card">
                        <img src="/images/1.png" alt="">
                    </div>
                    <div class="key_card">
                        Cosmic Black <br>
                        120GB
                    </div>
                    <div class="box_card">
                        <div class="box_card_inside">
                            <div class="box_card_inside_element_u">Einmalig</div>
                            <div class="box_card_inside_element_g">0,00 €</div>
                            <div class="box_card_inside_element_u">1. - 10. Monat</div>
                            <div class="box_card_inside_element_g">49,99 €</div>
                            <div class="box_card_inside_element">danach 54,99 €</div>
                        </div>
                    </div>
                    <div class="infobox_card">
                        - Großes 6,7 Zoll hochauflösendes AMOLED Display <br>
                        - Flüssigste Bilddarstellung dank 120 Hz Display <br>
                        - Hochaufklösende 64 MP 3-Fach Kamera mit 30x Zoom und 8k Videoaufnahmes
                    </div>
                </div>
                <div class="subcard">
                    + vergleichen
                </div>
            </div>
        </div>
        Aktuelle Bestseller mit [Tarif]
        <div class="cards">
            <div class="card-simulator">
                <div class="maincard">
                    <div class="name_card">
                        Samsung Galaxy S20+
                    </div>
                    <div class="bild_card">
                        <img src="/images/1.png" alt="">
                    </div>
                    <div class="key_card">
                        Cosmic Black <br>
                        120GB
                    </div>
                    <div class="box_card">
                        <div class="box_card_inside">
                            <div class="box_card_inside_element_u">Einmalig</div>
                            <div class="box_card_inside_element_g">0,00 €</div>
                            <div class="box_card_inside_element_u">1. - 10. Monat</div>
                            <div class="box_card_inside_element_g">49,99 €</div>
                            <div class="box_card_inside_element">danach 54,99 €</div>

                        </div>
                    </div>
                    <div class="infobox_card">
                        - Großes 6,7 Zoll hochauflösendes AMOLED Display <br>
                        - Flüssigste Bilddarstellung dank 120 Hz Display <br>
                        - Hochaufklösende 64 MP 3-Fach Kamera mit 30x Zoom und 8k Videoaufnahmes
                    </div>
                </div>
                <div class="subcard">
                    + vergleichen
                </div>
            </div>
            <div class="card-simulator">
                <div class="maincard">
                    <div class="name_card">
                        Samsung Galaxy S20+
                    </div>
                    <div class="bild_card">
                        <img src="/images/1.png" alt="">
                    </div>
                    <div class="key_card">
                        Cosmic Black <br>
                        120GB
                    </div>
                    <div class="box_card">
                        <div class="box_card_inside">
                            <div class="box_card_inside_element_u">Einmalig</div>
                            <div class="box_card_inside_element_g">0,00 €</div>
                            <div class="box_card_inside_element_u">1. - 10. Monat</div>
                            <div class="box_card_inside_element_g">49,99 €</div>
                            <div class="box_card_inside_element">danach 54,99 €</div>

                        </div>
                    </div>
                    <div class="infobox_card">
                        - Großes 6,7 Zoll hochauflösendes AMOLED Display <br>
                        - Flüssigste Bilddarstellung dank 120 Hz Display <br>
                        - Hochaufklösende 64 MP 3-Fach Kamera mit 30x Zoom und 8k Videoaufnahmes
                    </div>
                </div>
                <div class="subcard">
                    + vergleichen
                </div>
            </div>

            <div class="card-simulator">
                <div class="maincard">
                    <div class="name_card">
                        Samsung Galaxy S20+
                    </div>
                    <div class="bild_card">
                        <img src="/images/1.png" alt="">
                    </div>
                    <div class="key_card">
                        Cosmic Black <br>
                        120GB
                    </div>
                    <div class="box_card">
                        <div class="box_card_inside">
                            <div class="box_card_inside_element_u">Einmalig</div>
                            <div class="box_card_inside_element_g">0,00 €</div>
                            <div class="box_card_inside_element_u">1. - 10. Monat</div>
                            <div class="box_card_inside_element_g">49,99 €</div>
                            <div class="box_card_inside_element">danach 54,99 €</div>

                        </div>
                    </div>
                    <div class="infobox_card">
                        - Großes 6,7 Zoll hochauflösendes AMOLED Display <br>
                        - Flüssigste Bilddarstellung dank 120 Hz Display <br>
                        - Hochaufklösende 64 MP 3-Fach Kamera mit 30x Zoom und 8k Videoaufnahmes
                    </div>
                </div>
                <div class="subcard">
                    + vergleichen
                </div>
            </div>
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
          offers: [{"id":3,"name":"ANF S LTE","volume":"5","telefon":"Flat","price":"9,99","BK":1,"NK":1,"Special":null,"Cyber":null,"Beginner":null,"created_at":"2020-12-27T18:32:33.000000Z","updated_at":"2020-12-27T18:32:33.000000Z"},{"id":4,"name":"ANF M LTE","volume":"10","telefon":"Flat","price":"14.99","BK":1,"NK":1,"Special":null,"Cyber":null,"Beginner":null,"created_at":"2020-12-28T14:27:29.000000Z","updated_at":"2020-12-28T14:27:29.000000Z"}],
          counter: 2,
          offers2: 0,
        }
      },
        mounted() {
            console.log('Simulator mounted.')
            this.getOffers();
        },
        methods:{

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
          },
          getOffers(){
            axios.get('../offers/JSON')
            .then(response => {
              // console.log(response.data)
              this.offers2 = response.data;
              // console.log(this.offers2)
            })
            .catch(function (err) {
            console.log(err.response.data.message);
            })
          },
          getOffer(id){
            axios.get('../offer/JSON/'+id)
            .then(response => {
              // console.log(response.data)
              this.offers.push(response.data)
              this.$nextTick(() => {
                this.destroyModal('OffersModal')
                $('.modal-backdrop').remove()
              })
            })
            .catch(function (err) {
              console.log('error')
              console.log(err.response.data);
            })

          },
          openHWModal()
          {
            console.log('HW Modal')
            $('#HWModal').modal('show')
          },
          destroyModal(modalname)
          {
            let modal = document.querySelector('#'+modalname)
            modal.style.display = "none";
          },
          setActive(category)
          {
            $('.subauswahl').each(function(){
                this.className=''
                this.className='subauswahl'
            });
            event.target.className = 'subauswahl aktiv';
            this.getOffersByCategorie(category)
          },
          getOffersByCategorie(category)
          {
            axios.get('../offers/JSON/category/'+category)
            .then(response => {
              this.offers2 = response.data
            })
            .catch(function (err) {
              console.log('error')
              console.log(err.response.data);
            })
          }

        },
    }
</script>
