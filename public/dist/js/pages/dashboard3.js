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
        console.log(data);
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
              intersect: intersect
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
                  display: false
                },
                ticks: ticksStyle
              }]
            }
          }
        })
      }, error : function(){
        alert("error");
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
          labels: ['Planned', 'Actual',"Spent", 'Left to spend'],
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
            intersect: intersect
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
                display: false
              },
              ticks: ticksStyle
            }]
          }
        }
      })
    }, error : function() {
      alert("error");
    } 
  })
    

})

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
  }

// lgtm [js/unused-local-variable]
