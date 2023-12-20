$(function () {
  'use strict'

  var ticksStyle = {
    fontColor: '#495057',
    fontStyle: 'bold'
  }

  var mode 		 = 'index'
  var intersect  = true

  var chargingid = $(document).find("#chargingid").val();

	$.ajax({
	    url      : url+"/getbudgetutilization_graph",
	    type     : "post",
	    data     : { chargingid : chargingid },
	    dataType : "json",
	    success  : function(data) {
	      var obc_chart = $("#division-budget-line-chart");
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
	              display: true,
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
	      //alert("error");
	    } 
  })

var chargingid_1 = $(document).find("#chargingid_1").val();

$.ajax({
    url      : url+"/getdivision_graph",
    type     : "post",
    data     : { chargingid : chargingid_1 },
    dataType : "json",
    success  : function(data) {

      var obc_chart = $("#division-budget-chart");
      var obc = new Chart(obc_chart, {
        type: 'bar',
        data: {
          labels: ['Current',"Spent", 'Remaining'],
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
      // alert(chargingid);
    } 
  })
})

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
  }