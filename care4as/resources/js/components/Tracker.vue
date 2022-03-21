<template>
  <div class="row justify-content-center w-100" v-if="this.isHidden == false">
    <button type="button" name="button" id="closebutton" style="position:absolute; top: 5px; right: 5px" @click='closeElement()'>X</button>
    <div class="col-12" v-bind:id ="'chartcontainer' + this.userid">
      <canvas v-bind:id ="'myChart' + this.userid"></canvas>
    </div>
  </div>

</template>

<script>
import Chart from 'chart.js';

export default {
  props: ['userid'],
  data(){
    return{
      testusers: [1,2,3],
      data: null,
      isHidden: false,
      timer: '',
      testdata: [[0,15.38,30.3,33.33,36.25,40.91,45.99,45.18,49.48],[0,0,25,36.11,35,37.35,42.31,43.9,47.59],["08:01","08:30","09:00","09:30","10:00","10:30","11:00","11:30","12:00"]],
    }
  },
  mounted() {
      var self = this;
      console.log('Tracker Component mounted.')
      this.getUserData(this.userid)
      setInterval(function()
      {
        self.getUserData(self.userid)
      }, 600000);
    },
  methods:{
    createChart(chartId, chartData) {
    // console.log('test')

    let chart = document.getElementById(chartId);

    if (typeof chart != 'undefined' || chart != null )
    {
      document.getElementById(chartId).remove()
      $('#chartcontainer'+this.userid+'').append('<canvas id="'+chartId+'"></canvas>')
      // console.log('test')
    }

    const ctx = document.getElementById(chartId).getContext("2d");

    var gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(240, 152, 25, 0.7)');
    gradient.addColorStop(1, 'rgba(255, 81, 47, 0)');

    const myChart = new Chart(ctx, {
      type: 'bar',

      data: {
          datasets: [{
           type: 'line',
           label: 'CR',
           data: chartData[1],
           // data: chartData[1],
           fill: true,
           backgroundColor: gradient,
           borderColor: '#f09819',
           borderWidth: 1
       },
       {
          label: 'Calls',
          type: 'bar',
          yAxisID: 'B',
          data: chartData[2],
          backgroundColor: 'rgba(255, 99, 132)',
          borderWidth: 1
    }],
    labels:chartData[0],
     },
     options: {
         scales: {
           yAxes: [{
             id: 'A',
             type:'linear',
             position: 'left',
             ticks: {
               beginAtZero: true,
               min: 0,
               max: 100,
           }
         },
         {
           id: 'B',
           type:'linear',
           position: 'right',
           ticks: {
             max: 10,
             min: 0,
           }
         }]}
       }
    });
  },
  getUserData(id)
  {
    document.querySelectorAll('.col-12 bg-light').forEach(function(column) {
      column.innerHTML = ''
    })

    var host = window.location.host;
    // axios.get('http://'+host+'/care4as/care4as/public/user/getTracking/'+this.userid)
    let testdata = this.testdata
    axios.get('http://'+host+'/user/getTracking/'+this.userid)
    .then(response => {
      // console.log(response)
      if(response.data[0][0])
      {
        console.log(response.data[0][0])
        this.createChart('myChart' + this.userid,response.data)
      }
      else
      {
        this.createChart('myChart' + this.userid, this.testdata)
        console.log('No Data avaiable')
      }
      })
    .catch(err => {
      this.createChart('myChart' + this.userid, testdata)
      console.log('error Tracker11')
      console.log(testdata)
      console.log(err);
    })
  },
  closeElement()
  {
    $(this.$el).parent()[0].remove()
      // remove the element from the DOM
  }
},

    }
</script>
