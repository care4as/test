<template>
  <div class="row justify-content-center w-100">
    <div class="col-12 bg-light">
    <canvas id="myChart"></canvas>
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
    }
  },
    mounted() {
        console.log('Tracker Component mounted.')
        this.getUserData(1)
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
           backgroundColor: [
               'rgba(255, 99, 132, 0.2)',
           ],
           borderColor: [
               'rgba(255, 99, 132, 1)',
           ],
           borderWidth: 1
       }]
     },
      options: chartData.options,
    });
  },
  getUserData(id)
  {
    console.log(this.userid)
    axios.get('user/getTracking/'+id)
    .then(response => {
      // console.log(response)
      if(response.data[0][0])
      {
        console.log(response.data)
        this.createChart('myChart',response.data)
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
  }
},
}
</script>
