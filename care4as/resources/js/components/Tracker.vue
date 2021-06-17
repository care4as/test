<template>
  <div class="row justify-content-center w-100" v-if="this.isHidden == false">
    <button type="button" name="button" id="closebutton" style="position:absolute; top: 5px; right: 5px" @click='closeElement()'>X</button>
    <div class="col-12 bg-light">
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

    const ctx = document.getElementById(chartId);
    const myChart = new Chart(ctx, {
      type: 'bar',

      data: {
          datasets: [{
           type: 'line',
           label: 'CR',
           data: chartData[1],
           fill: false,
           backgroundColor: 'rgba(41, 241, 195, 1)',
           borderColor: 'rgba(41, 241, 195, 1)',
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
    //axios.get('http://'+host+'/care4as/care4as/public/user/getTracking/'+this.userid)
    axios.get('http://'+host+'/user/getTracking/'+this.userid)
    .then(response => {
      // console.log(response)
      if(response.data[0][0])
      {
        // console.log(response.data)
        this.createChart('myChart' + this.userid,response.data)
      }
      else
      {
        console.log('No Data avaiable')
      }
      })
    .catch(function (err) {
      console.log('error')
      console.log(err.response);
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
