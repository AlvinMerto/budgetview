/* global Chart:false */

$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode = 'index'
  var intersect = true

    $.ajax({
      url      : url+"/getperdivisionaverall",
      type     : "post",
      data     : { },
      dataType : "json",
      success  : function(data) { 
        var $salesChart = $('#sales-chart')
        // eslint-disable-next-line no-unused-vars
        var salesChart = new Chart($salesChart, {
          type: 'bar',
          data: {
            labels: data['label'],
            datasets: [
              {
                backgroundColor: '#007bff',
                borderColor: '#007bff',
                data: data['lefttospend']
              },
              {
                backgroundColor: '#5dcac0',
                borderColor: '#5dcac0',
                data: data['actualbudget']
              },
              {
                backgroundColor: '#6c757d',
                borderColor: '#6c757d',
                data: data['spent']
              }
            ]
          },
          options: {
            maintainAspectRatio: false,
            tooltips: {
              mode: mode,
              intersect: intersect,
              callbacks: {
                label: (ttItem, data) => (numberWithCommas(ttItem.value) + " PHp")
              }
            },
            hover: {
              mode: mode,
              intersect: intersect
            },
            legend: {
              display: false
            },
            scales: {
              yAxes: [{
                // display: true,
                gridLines: {
                  display: true,
                  lineWidth: '4px',
                  color: 'rgba(0, 0, 0, .2)',
                  zeroLineColor: 'transparent'
                },
                ticks: $.extend({
                  beginAtZero: true,

                  // Include a dollar sign in the ticks
                  callback: function (value) {
                    // if (value >= 1000) {
                    //   value /= 1000
                    //   value += 'k'
                    // }

                    return numberWithCommas(value)
                  }
                }, ticksStyle)
              }],
              xAxes: [{
                display: true,
                gridLines: {
                  display: true
                },
                ticks: ticksStyle
              }]
            }
          }
        })
      }, error : function(){
        // alert("error");
      }
    })


  $.ajax({
    url      : url+"/getofficebudget",
    type     : "post",
    data     : { },
    dataType : "json",
    success  : function(data) {
      var obc_chart = $("#office-budget-chart");
      var obc = new Chart(obc_chart, {
        type: 'bar',
        data: {
          labels: ['Planned', 'Current',"Spent", 'Remaining'],
          datasets: [
            {
              backgroundColor: '#007bff',
              borderColor: '#007bff',
              data: data
            }
          ]
        },
        options: {
          maintainAspectRatio: false,
          tooltips: {
            mode: mode,
            intersect: intersect,
            callbacks: {
                label: (ttItem, data) => (numberWithCommas(ttItem.value) + " PHp")
            }
          },
          hover: {
            mode: mode,
            intersect: intersect
          },
          legend: {
            display: false
          },
          scales: {
            yAxes: [{
              // display: false,
              gridLines: {
                display: true,
                lineWidth: '4px',
                color: 'rgba(0, 0, 0, .2)',
                zeroLineColor: 'transparent'
              },
              ticks: $.extend({
                beginAtZero: true,

                // Include a dollar sign in the ticks
                callback: function (value) {
                  // if (value >= 10500) {
                  //   value /= 1000
                  //   value += 'k'
                  // }

                  return numberWithCommas(value)
                }
              }, ticksStyle)
            }],
            xAxes: [{
              display: true,
              gridLines: {
                display: true
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    }, error : function() {
      // alert("error");
    } 
  })
  
  var pieChartCanvas = $('#leave-distribution').get(0).getContext('2d')
  var theyear = $(document).find("#theyearholder").val();

  $.ajax({
    url      : url+"/get_pie_data",
    type     : "post",
    data     : { theyear : theyear },
    dataType : "json",
    success  : function(data) {
      var pieData = {
        labels: data[1],
        datasets: [
          {
            data: data[0],
            backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de']
          }
        ]
      }
      
      var pieOptions = {
        legend: {
          display: true
        }
      }

      var pieChart = new Chart(pieChartCanvas, {
        type: 'doughnut',
        data: pieData,
        options: pieOptions
      })
    },
    error :function() {
      alert("error");
    }
  });

})

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
  }

  function sortTable(tbl) {

    var table, rows, switching, i, x, y, shouldSwitch;
    table = document.getElementById(tbl);
    switching = true;
    /* Make a loop that will continue until
    no switching has been done: */
    while (switching) {
      // Start by saying: no switching is done:
      switching = false;
      rows = table.rows;
      /* Loop through all table rows (except the
      first, which contains table headers): */
      for (i = (rows.length - 1); i > 1 ; i--) {
        // Start by saying there should be no switching:
        shouldSwitch = false;
        /* Get the two elements you want to compare,
        one from current row and one from the next: */
        x = rows[i].getElementsByTagName("TD")[4];
        y = rows[i - 1].getElementsByTagName("TD")[4];
        // Check if the two rows should switch place:
        if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
          // If so, mark as a switch and break the loop:
          shouldSwitch = true;
          break;
        }
      }
      if (shouldSwitch) {
        /* If a switch has been marked, make the switch
        and mark that a switch has been done: */
        rows[i].parentNode.insertBefore(rows[i - 1], rows[i]);
        switching = true;
      }
    }
  }


// lgtm [js/unused-local-variable]
