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
	      var obc_chart = $("#division-budget-chart");
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

  // $(document).find(".displaycharges").on("click", function(){
  // 	var activitygrp = $(this).data("activitygrp");

  // 	$.ajax({
  // 		url 		: url+"/displaycharges",
  // 		type 		: "get",
  // 		data 		: { activitygrp : activitygrp },
  // 		dataType    : "html",
  // 		success     : function(html){
  // 			$(document).find("#appear_here_"+activitygrp).append(html);
  // 		}, error    : function() {
  // 			alert("error retrieving charges");
  // 		}
  // 	})
  // });

})

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
  }