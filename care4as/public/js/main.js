function toggleSidebar()
{
  // console.log('test')
  let sidebar = document.querySelector('#sidebar');
  let content = document.querySelector('#main-panel');
  let width = sidebar.getBoundingClientRect().width

  // console.log(width)

  if(width > 0)
  {
    sidebar.style.display = 'none'
    content.style.width = '100%'
    let table = document.querySelector('#tableoverview')
    if(table)
    {
      table.style.width = '100%'
    }

    // console.log(logo)
  }
  else {
    sidebar.style.display = 'block'
    newOldWidth = 'calc(100% - 260px)';
    content.style.width = newOldWidth
  }

}

function getAHT(date1,date2)
{
  let loader = document.querySelector('.loader')
  loader.style.display = 'block'
  let button = document.querySelector('.aht')
  button.style.display = 'none'
}
function printPage()
{
  // console.log('test')
  toggleSidebar()

  let container = document.querySelector('.printer')
  console.log(container)
  container.style.width = '100%'
  window.print()
}

  /* Set the width of the sidebar to 250px and the left margin of the page content to 250px */
  function openNav() {
      document.getElementById("sidebar").style.display = "none";
      document.getElementById("main-panel").style.width = "100%";
      // document.getElementById("sidebar-wrapper").style.display = "none";
  }

  /* Set the width of the sidebar to 0 and the left margin of the page content to 0 */
  function closeNav() {
      document.getElementById("sidebar").style.display = "block";
      document.getElementById("main-panel").style.width = "calc(100% - 260px)";
        // document.getElementById("sidebar-wrapper").style.display = "block";
  }

  function showSidebar(){
      var selection = document.getElementById("hamburg");
      if (selection.checked) {
          openNav()
      }
      else {
          closeNav()
      }
  }
  function showChart(type,userid) {

      var start = moment().subtract(29, 'days');
      var end = moment();
      var host = window.location.host;
      var userid = userid

      function cb(start, end) {

          $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));

          // console.log(start.format('YY-MM-DD') + '/' +end.format('YY-MM-DD') )
          let params = new URLSearchParams();
          params.append("start", start);
          params.append("end" , end);
          params.append("userid" , userid);

          let chart = document.getElementById('Chart');

          if (typeof chart != 'undefined' || chart != null )
          {
            document.getElementById('Chart').remove()
            $('#chartcontainer').append('<canvas id="Chart" width="" height=""style="height: 60vh; max-width: 90%;"></canvas>')
            // console.log('test')
          }

          if(type== 'sales')
          {
            // axios.get('http://'+host+'/care4as/care4as/public/user/salesdataDates',
           axios.get('http://'+host+'/user/salesdataDates',
           {
             params: {
               start: start.format('Y-MM-DD'),
               end: end.format('Y-MM-DD'),
               userid: userid
             }
             })
           .then(response => {
             let chartData = response.data
             var ctx = document.getElementById('Chart').getContext('2d')
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
                   label: 'durschnittliche CR',
                   type: 'line',
                   label: 'CR durschn.',
                   data: chartData[2],
                   fill: false,
                   backgroundColor: 'rgba(255, 99, 132)',
                   borderColor: 'rgba(255, 99, 132, 1)',
                   borderWidth: 1
             },
                {
                   label: 'durschnittliche SSC-CR',
                   type: 'line',
                   label: 'SSC-CR durschn.',
                   data: chartData[3],
                   fill: false,
                   backgroundColor: 'rgba(0, 155, 119)',
                   borderColor: 'rgba(0, 155, 119, 1)',
                   borderWidth: 1
             },
                {
                   label: 'SSC-CR',
                   type: 'line',
                   label: 'SSC-CR',
                   data: chartData[4],
                   fill: false,
                   backgroundColor: 'rgba(136, 176, 75)',
                   borderColor: 'rgba(136, 176, 75, 1)',
                   borderWidth: 1
             }
           ],
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
                }});
             })
           .catch(function (err) {
             console.log(err.response);
             $('#failContent').html('Fehler: '+ err.response.data.message)
             $('#failFile').html('Datei: '+ err.response.data.file)
             $('#failLine').html('Line: '+ err.response.data.line)
             $('#failModal').modal('show')
             // $('#loaderDiv').css('display','none');
           })
          }
          else if(type== 'aht')
          {
            // axios.get('http://'+host+'/care4as/care4as/public/user/salesdataDates',
           axios.get('http://'+host+'/user/salesdataDates',
           {
             params: {
               start: start.format('Y-MM-DD'),
               end: end.format('Y-MM-DD'),
               userid: userid
             }
             })

           .then(response => {
             let data = response.data

             var ctx = document.getElementById('Chart').getContext('2d')

             var myChart = new Chart(ctx, {
              type: 'bar',
              data: {
                  labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                  datasets: [{
                      label: '# of Votes',
                      data: [12, 19, 3, 5, 2, 3],
                      backgroundColor: [
                          'rgba(255, 99, 132, 0.2)',
                          'rgba(54, 162, 235, 0.2)',
                          'rgba(255, 206, 86, 0.2)',
                          'rgba(75, 192, 192, 0.2)',
                          'rgba(153, 102, 255, 0.2)',
                          'rgba(255, 159, 64, 0.2)'
                      ],
                      borderColor: [
                          'rgba(255, 99, 132, 1)',
                          'rgba(54, 162, 235, 1)',
                          'rgba(255, 206, 86, 1)',
                          'rgba(75, 192, 192, 1)',
                          'rgba(153, 102, 255, 1)',
                          'rgba(255, 159, 64, 1)'
                      ],
                      borderWidth: 1
                  }]
              },
              options: {
                  scales: {
                      y: {
                          beginAtZero: true
                      }
                  }
              }
          });

           })
           .catch(function (err) {
             console.log(err.response);
             $('#failContent').html('Fehler: '+ err.response.data.message)
             $('#failFile').html('Datei: '+ err.response.data.file)
             $('#failLine').html('Line: '+ err.response.data.line)
             $('#failModal').modal('show')
             // $('#loaderDiv').css('display','none');
           })
            console.log('test')
          }
        }

      $('#reportrange').daterangepicker({
          startDate: start,
          endDate: end,
          ranges: {
             'Today': [moment(), moment()],
             'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
             'Last 7 Days': [moment().subtract(6, 'days'), moment()],
             'Last 30 Days': [moment().subtract(29, 'days'), moment()],
             'This Month': [moment().startOf('month'), moment().endOf('month')],
             'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
          }
      }, cb);
  };
