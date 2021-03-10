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


    // let logo = document.querySelector('.logo')
    // logo.style.display = 'none'
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
