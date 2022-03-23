<template>
  <div class="row h-100 w-100 justify-content-center align-bottom m-2">
    <div class="col-md-5 h-50 m-1 p-2 center_items" v-bind:class= "[this.sscCR > 15 ? 'bg-success' : 'bg-danger text-white']">
      <div class="">
        <div class="row m-1 text-center">
          SSC-CR:
        </div>
        <div class="row m-1">
          <div class="col-6">
            <p>{{this.sscCR}}<i class="fa-solid fa-arrow-trend-down"></i></p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5 h-50 m-1 p-2 center_items" v-bind:class= "[this.bscCR > 15 ? 'bg-success' : 'bg-danger text-white']">
      <div class="">
        <div class="row m-1 text-center">
          BSC-CR:
        </div>
        <div class="row m-1">
          <div class="col-6">
            <p>{{this.bscCR}} <i class="fa-solid fa-arrow-trend-down"></i></p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5 h-50 m-1 p-2 center_items" v-bind:class= "[this.portalCR > 15 ? 'bg-success' : 'bg-danger text-white']">
      <div class="">
        <div class="row m-1 text-center">
          Portal-CR:
        </div>
        <div class="row m-1">
          <div class="col-6">
            <p>{{this.portalCR}}<i class="fa-solid fa-arrow-trend-down"></i></p>
          </div>
        </div>
      </div>
    </div>
    <div class="col-md-5 h-50 m-1 p-2 center_items" v-bind:class= "[this.optinQuota > 15 ? 'bg-success' : 'bg-danger text-white']">
      <div class="">
        <div class="row m-1 text-center">
          Optinquote:
        </div>
        <div class="row m-1">
          <div class="col-6">
            <p>{{this.optinQuota}} <i class="fa-solid fa-arrow-trend-down"></i></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
    export default {
      data(){
        return {
          timer: '',
          SscGeVoCr: 0,
          sscCalls: 0,
          bscCalls: 0,
          bscSaves: 0,
          portalCalls: 0,
          portalSaves: 0,
          sscSaves: 0,
          calls:0,
          saves:0,
          optins: 0,
        }
      },
      mounted() {
        var self = this;
        console.log('dbMonitor Component mounted.')
        self.getUserData()
        // self.getDailyQouta('Mobile')
        this.timer =
        setInterval(function()
        {
          // self.getUserData('Mobile')
          // self.getDailyQouta('Mobile')
        }, 60000);
      },
        computed:{
          GeVoCr: function(){
            if (this.calls != 0) {
              return Math.round((this.saves*100/this.calls)*100)/100
            }
            else {
              // return this.saves
              return 0
            }
          },
          optinQuota: function(){
            if (this.calls != 0) {
              return Math.round((this.optins*100/this.calls)*100)/100
            }
            else {
              // return this.saves
              return 0
            }
          },
          bscCR: function(){
            if (this.bscCalls != 0) {
              return Math.round((this.bscSaves*100/this.bscCalls)*100)/100
            }
            else {
              return 0
            }
          },
          portalCR: function(){
            if (this.portalCalls != 0) {
              return Math.round((this.portalSaves*100/this.portalCalls)*100)/100
            }
            else {
              return 0
            }

          },
          sscCR: function(){
            if (this.sscCalls != 0) {
              return Math.round((this.sscSaves*100/this.sscCalls)*100)/100
            }
            else {
              return 0
            }
          },
        },
        methods:{
          getUserData(){

            var host = window.location.host;
            var department = this.department
            var currentdate = new Date();
            let timestamp = "Last Sync: " + currentdate.getDate() + "/"
                  + (currentdate.getMonth()+1)  + "/"
                  + currentdate.getFullYear() + " @ "
                  + currentdate.getHours() + ":"
                  + currentdate.getMinutes() + ":"
                  + currentdate.getSeconds();

            axios.get
            // ('http://'+host+'/care4as/care4as/public/users/getTracking/Mobile')
            ('http://'+host+'/users/getTracking/Mobile')
            .then(response => {
              if(response.data)
              {
                console.log(response.data)
                var currentdate = new Date();
                console.log('update: '+timestamp)

                if(this.department == 'Mobile')
                {
                  this.users = response.data[0]
                  this.sscCalls = response.data[1]['ssc_calls']
                  this.sscSaves = response.data[1]['ssc_saves']
                  this.bscSaves = response.data[1]['bsc_saves']
                  this.bscCalls = response.data[1]['bsc_calls']
                  this.portalCalls = response.data[1]['portal_calls']
                  this.portalSaves = response.data[1]['portal_saves']
                  this.calls = response.data[1]['calls']
                  this.saves = response.data[1]['orders']
                  this.optins = response.data[1]['optins']
                }
                else {
                  this.users = response.data[0]
                  this.calls = response.data[1]['calls']
                  this.saves = response.data[1]['orders']
                }
              }
              else
              {
                console.log('No Data avaiable')
              }
              })
            .catch(function (err) {
              console.log('error Userdata Ptable')
              console.log(err.response);
            })
          },
        }
    }
</script>
