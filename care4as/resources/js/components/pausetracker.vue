<template>
    <div class="container">
        <div class="row justify-content-center">
          <div class="col">
            <h2>Wer ist in Pause?</h2>
            <table class="table table-striped text-black">
              <tr>
                <th>Name</th>
                <th>seit</th>
              </tr>
              <tr  v-for="user in users">
                <td>{{user.name}}</td>
                <td v-if="user.created_at">{{calcTimeDifference(user.created_at)}}</td>
                <td v-else>keine Angabe</td>
              </tr>
            </table>
          </div>
        </div>
        <div class="row center_items">
          <div class="col-6 center_items">
              <button type="button" class="btn-primary rounded-circle" name="button" @click="goIntoPause()">In Pause gehen!</button>
          </div>
          <div class="col-6 center_items">
              <button type="button" name="button" @click="getOutOfPause()">Pause beendet</button>
          </div>
        </div>
    </div>
</template>

<script>
    export default {

      data(){
        return{
          users: [1,2,3],
          }
        },
        mounted() {
            console.log('PauseTool mounted.')
            var self = this;
            console.log('ptable Component mounted.')
            self.getUsers()
            this.timer =
            setInterval(function()
            {
              self.getUsers()
            }, 5000);
        },
        methods:{

          getUsers()
          {
            var host = window.location.host;

            axios.get('http://'+host+'/care4as/care4as/public/telefonica/getUsersInPause')
            // axios.get('http://'+host+'/telefonica/getIntoPause')
            .then(response => {
              console.log(response.data)
              this.users = response.data
            })
            .catch(function (err) {
              console.log('error')
              console.log(err);
            })
          },
          goIntoPause(){

            var host = window.location.host;
            axios.get('http://'+host+'/care4as/care4as/public/telefonica/getIntoPause')
            // axios.get('http://'+host+'/telefonica/getIntoPause')
            .then(response => {
              console.log(response.data)
              if (response.data =="du bist schon in Pause") {
                $('#failContent').text(response.data)
                $('#failModal').modal('show')
              }
              else if (response.data.includes("angenehme Pause")) {
                $('#smodaltext').text(response.data)
                $('#successModal').modal('show')
              }
              else {
                $('#failContent').text('zuviele Leute in Pause')
                $('#failModal').modal('show')
              }

            })
            .catch(function (err) {
              console.log('error')
              console.log(err.response);
            })
          },
          getOutOfPause(){

            var host = window.location.host;
            axios.get('http://'+host+'/care4as/care4as/public/telefonica/getOutOfPause')
            // axios.get('http://'+host+'/telefonica/getOutOfPause')
            .then(response => {
                console.log(response.data)
            })
            .catch(function (err) {
              console.log('error')
              console.log(err.response);
            })
          },
          calcTimeDifference(since)
          {
            var start = new Date(since);
            var end = new Date(Date.now());
            var Difference_In_Time = (end.getTime() - start.getTime())/1000 ;

            var result = new Date(Difference_In_Time * 1000).toISOString().substr(14,5);
            return result
          }
        }
    }
</script>
