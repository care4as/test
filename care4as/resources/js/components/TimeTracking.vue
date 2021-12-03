<template>
    <div class="d-flex bg-light" style="border-radius: 15px; width: 20em !important;">
        <div class="row center_items h-100 m-3" >
            <div class="col">
                <div class="row">
                  <div class="col-4 p-3 center_items bg-test5" style="position:relative;">
                    <div class="" style="position: absolute; ">
                      <p>Verfügbar</p>
                    </div>
                    <button @click="changeStatus('Verfügbar')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="fas fa-play fa-2x"></i></button>
                  </div>
                  <div class="col-4 p-3 center_items bg-test8" style="position:relative;">
                    <div class="" style="position: absolute; top: 5px; ">
                      Langpause
                      <p></p>
                    </div>
                    <button @click="changeStatus('Kurzpause')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="fas fa-play fa-2x"></i></button>
                  </div>
                  <div class="col-4 p-3 center_items bg-test3" style="position:relative;">
                    <div class="" style="position: absolute;">
                      <p>Kurzpause <br>
                        Rauchen, WC</p>
                    </div>
                    <button @click="changeStatus('Verfügbar')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="fas fa-play fa-2x"></i></button>
                  </div>
                  <div class="col-4 p-3 center_items bg-test4" style="position:relative;">
                    <div class="" style="position: absolute;">
                      Meeting
                    </div>
                    <button @click="changeStatus('Meeting')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="fas fa-play fa-2x"></i></button>
                  </div>
                  <div class="col-4 p-3 center_items bg-test2" style="position:relative;">
                    <div class="" style="position: relative;overflow:hidden;height: 100px; width:100px; border-radius:50%; border: solid white 3px;">
                      <div class="bg-danger center_items" id="progress" style="">
                        {{this.progress}}
                      </div>
                    </div>
                  </div>
                  <div class="col-4 p-3 center_items bg-test9" style="position:relative;">
                    <div class="" style="position: absolute;">
                      In Schulung
                    </div>
                    <button @click="changeStatus('In Schulung')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="fas fa-play fa-2x"></i></button>
                  </div>
                  <div class="col-4 p-3 center_items bg-test1" style="position:relative;">
                    <div class="" style="position: absolute;">
                      Systemausfall
                    </div>
                    <button @click="changeStatus('Verfügbar')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="fas fa-play fa-2x"></i></button>
                  </div>
                  <div class="col-4 p-3 center_items bg-test7" style="position:relative;">
                    <div class="" style="position: absolute;">
                      test
                    </div>
                    <button @click="changeStatus('Verfügbar')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="fas fa-play fa-2x"></i></button>
                  </div>
                  <div class="col-4 p-3 center_items bg-test6">
                    <div class="" style="position: absolute;">
                      Adios Care4as!
                    </div>
                    <button @click="changeStatus('Feierabend')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="far fa-stop-circle fa-2x"></i></button>
                  </div>
                </div>
                <div class="row">
                  Im Status {{this.status}} seit {{duration}} Minuten
                </div>

            </div>
        </div>
    </div>
</template>

<script>
    export default {

      data(){
        return{
          user: '',
          timer: '',
          status: 'test',
          status_start: 1,
          duration: '',
          progress: 0,
          duty: 8,
        }
      },
      mounted() {
        console.log('Timetracker mounted.')
      },
      computed:{
      },
      methods:{
        changeStatus(status){
          //the state the user is in

          //the timestamp when the user clicked
          this.status_start = new Date()

          if(status !== 'Feierabend')
          {
            setInterval(this.calcTimeDifference, 1000);
            setInterval(this.updateProgress, 1000);
            this.status = status
          }
          else
          {
            this.status = null
            console.log('feierabend')
            clearInterval()
          }

          //count up the time
        },
        updateProgress()
        {
          let rest = (((this.duty*60)/100) * this.progress)
           // (this.progress/100)

          let a = this.duration.split(':'); // split it at the colons
          // minutes are worth 60 seconds. Hours are worth 60 minutes.
          var diff = rest - ((+a[0]) * 60 + (+a[1]));
          let percent = Math.round((diff/rest) * 100,2)
          // let percent = diff/duty
          this.progress = percent
          $('#progress').height(100 - percent)

          console.log((this.duty*60)/100)
        },
        calcTimeDifference()
        {
          var start = new Date(this.status_start);
          var end = new Date(Date.now());
          var Difference_In_Time = (end.getTime() - start.getTime())/1000 ;

          var result = new Date(Difference_In_Time * 1000).toISOString().substr(14,5);
          this.duration = result
        },
        storeStatus()
        {
          axios.get
          // ('http://'+host+'/care4as/care4as/public/users/getTracking/'+department)
          ('http://'+host+'/users/getTracking/'+department)
          .then(response => {
            if(response.data)
            {
              console.log('data received')
            }
            else {
              console.log('data not received received')
            }
          })
          .catch(function (err) {
            console.log('error Userdata Ptable')
            console.log(err.response);
          })
        }
    }
    }
</script>
<style media="screen">
  

  </style>
