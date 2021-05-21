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
