var newSidebar = "active";

//function für controlling: Umsatzmeldung
function controlling_umsatzmeldung_zielwerte_toggle(){
  if (document.getElementById('controlling_umsatzmeldung_zielwerte_toggle').style.visibility == "hidden") {
    document.getElementById('controlling_umsatzmeldung_zielwerte_toggle').style.visibility = "visible"
  } else {
    document.getElementById('controlling_umsatzmeldung_zielwerte_toggle').style.visibility = "hidden";
  }
  
}


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

function showDetails(id)
{
  $("#details"+id).css('display','block')
}

function hide(el)
{
  el.style.display = 'none'
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

// Sidebar Toggler
function toggleNewSidebar(){
  if (window.newSidebar == "active") {
    document.getElementById("main-panel").style.width = "100%";
    window.newSidebar = "transition";
    setTimeout(function(){
      document.getElementById("navbar_max").style.boxShadow = "none"
      window.newSidebar = "inactive";
    }, 150);
  } else if (window.newSidebar == "inactive") {
    window.newSidebar = "transition";
    document.getElementById("main-panel").style.width = "calc(100% - 260px)";
    document.getElementById("navbar_max").style.boxShadow = "black 1em 0px 1em -1em inset"
    setTimeout(function(){
      window.newSidebar = "active";
    }, 150)
  }
  document.getElementById("linkNewSidebar").style.backgroundColor = "transparent";
}

function mouseoverNewSidebar(){
  if (window.newSidebar == "active") {
    document.getElementById("hoverNewSidebarToggler").className = "now-ui-icons arrows-1_minimal-left";
  } else if (window.newSidebar == "inactive") {
    document.getElementById("hoverNewSidebarToggler").className = "now-ui-icons arrows-1_minimal-right";
  }
  document.getElementById("linkNewSidebar").style.backgroundColor = "rgba(255, 255, 255, 0.2)";
}

function mouseoutNewSidebar(){
  document.getElementById("hoverNewSidebarToggler").className = "now-ui-icons design_bullet-list-67";
  document.getElementById("linkNewSidebar").style.backgroundColor = "transparent";
  
}


  function rotateButton(){

    var button = $("#LexikaButton");

    if(button.hasClass('rotateButton'))
    {
      button.addClass('rotateBack')
      button.removeClass('rotateButton')
    }
    else {
      button.addClass("rotateButton");
      button.removeClass('rotateBack')
    }

    $('.Lexika').toggle()

  }
  function loadData(path,el, elpop)
  {

    console.log(path)
    let host = window.location.host;

    // axios.get('http://'+host+'/care4as/care4as/public/reports/'+path)

    console.log(path)
    axios.get('http://'+host+'/reports/'+path)
    .then(response => {

      // console.log(response)
      let min = response.data[0]
      let max = response.data[1]

      // let element = $('#RDDataStatus')
      let element = $(el)

      // $('.loadingerRD').toggle()
      $(elpop).toggle()

      element.css( 'display','block')

      if (elpop == '.loadingerRD') {
        element.html('Retention-Details von '+min+' bis: '+max)
      }
      else if (elpop == '.loadingerHR') {
          element.html('Stundenreport von '+min+' bis: '+max)
      }
      else if (elpop == '.loadingerOptin') {
        element.html('Optin von '+min+' bis: '+max)
      }
      else if (elpop == '.loadingerSAS') {
        element.html('SAS von '+min+' bis: '+max)
      }
      else if(elpop == '.loadingerDA') {
        element.html('Daily Agent von '+min+' bis: '+max)
      }

    })
    .catch(function (err) {
      if (elpop == '.loadingerRD') {
        console.log('error DataStatus RetentionDetail')
      }
      else if (elpop == '.loadingerHR') {
        console.log('error DataStatus Stundenreport')
      }
      else if (elpop == '.loadingerOptin') {
        console.log('error DataStatus Optin')
      }
      else if (elpop == '.loadingerSAS') {
        console.log('error DataStatus SAS')
      }
      else if(elpop == '.loadingerDA') {
        console.log('error DataStatus Daily Agent')
      }

      console.log(err.response);
    });
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
            $('#loaderDiv').css('display','block')

            // console.log($('#loaderDiv'));
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
             // console.log(response)
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
                $('#loaderDiv').css('display','none')
             })
           .catch(function (err) {

             $('#loaderDiv').css('display','none')
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
           $('#loaderDiv').css('display','block')

           axios.get('http://'+host+'/test',
           // axios.get('http://'+host+'/care4as/care4as/public/test',
           {
             params: {
               start: start.format('Y-MM-DD'),
               end: end.format('Y-MM-DD'),
               userid: userid
             }
             })
           .then(response => {
             let chartData = response.data
             console.log(chartData[3])
             var ctx = document.getElementById('Chart').getContext('2d')
               const myChart = new Chart(ctx, {
                 type: 'bar',
                 data: {
                     datasets: [{
                      type: 'line',
                      label: 'AHT',
                      data: chartData[1],
                      fill: false,
                      backgroundColor: 'rgba(41, 241, 195, 1)',
                      borderColor: 'rgba(41, 241, 195, 1)',
                      borderWidth: 1
                  },
                  {
                    type: 'line',
                    label: 'on Hold',
                    data: chartData[2],
                     yAxisID: 'B',
                    fill: false,
                    backgroundColor: 'rgba(255, 10, 10, 1)',
                    borderColor: 'rgba(255, 10, 10, 1)',
                    borderWidth: 1
                  },
                  {
                    type: 'line',
                    label: 'Occupied',
                    data: chartData[3],
                    yAxisID: 'B',
                    fill: false,
                    backgroundColor: 'rgba(10, 255, 10, 1)',
                    borderColor: 'rgba(10, 255, 10, 1)',
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
                            suggestedMin: 300,
                            suggestedMin: 1200,
                            stepSize: 200,
                        }
                      },
                      {
                        id: 'B',
                        type:'linear',
                        position: 'right',
                        ticks: {
                          suggestedMin: 120,
                          suggestedMin: 0,
                          stepSize: 20,
                        }
                      }]}
                    }});
                    $('#loaderDiv').css('display','none')
               })
             .catch(function (err) {

               $('#loaderDiv').css('display','none')
               console.log(err);
               $('#failContent').html('Fehler: '+ err.response.data.message)
               $('#failFile').html('Datei: '+ err.response.data.file)
               $('#failLine').html('Line: '+ err.response.data.line)
               $('#failModal').modal('show')
               $('#loaderDiv').css('display','none');
             })
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
