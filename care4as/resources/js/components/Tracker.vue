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
    }
  },
    mounted() {
        console.log('Tracker Component mounted12.')
        this.getUserData(this.userid)
    },
  methods:{
    createChart(chartId, chartData) {

    const ctx = document.getElementById(chartId);
    const myChart = new Chart(ctx, {
      type: 'line',

      data: {
        labels:chartData[0],
        datasets: [{
           data: chartData[1],
           fill: false,
           backgroundColor: [
               'rgba(255, 99, 132, 0.2)',
           ],
           borderColor: [
               'rgba(255, 99, 132, 1)',
           ],
           borderWidth: 1
       }]
     },
     options: {
         scales: {
           yAxes: [{
             ticks: {
               beginAtZero: true,
               min: 0,
               max: 100,
           }
           }]
         }
       }
    });
  },
  getUserData(id)
  {
	console.log('test')
    axios.get('/user/getTracking/'+this.userid)
    .then(response => {
      console.log(response)
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

    console.log($(this.$el).parent()[0].remove())

      // remove the element from the DOM
    // $(this.$el).remove();

  }
},
}
</script>
