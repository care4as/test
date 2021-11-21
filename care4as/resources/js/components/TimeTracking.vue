<template>
    <div class="container bg-light">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="row">
                  <h5>Zeiterfassung</h5>
                </div>
                <hr>
                <div class="row">
                  Im Status {{this.status}} seit {{duration}} Minuten
                </div>
                <div class="row">
                  <div class="col-md">
                    <button @click="changeStatus('Verfügbar')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="fas fa-play fa-2x"></i></button>
                  </div>
                  <div class="col-md">
                    <button @click="changeStatus('Feierabend')" type="button" name="button" class="btn-primary rounded-circle p-3 d-flex justify-content-center"><i class="far fa-stop-circle fa-2x"></i></button>
                  </div>
                  <div class="col-md">
                    <select class="custom-select" id="status">
                     <option selected>Achtung beim Klicken</option>
                     <option value="1" @click="changeStatus('Kurzpause')">Kurzpause</option>
                     <option value="2" @click="changeStatus('Langpause')">Langpause</option>
                     <option value="3" @click="changeStatus('Meeting')">Meeting</option>
                   </select>
                  </div>
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
