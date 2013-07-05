
$(document).ready(function(){

  var data = [];
  $.ajax({
    url: '/js/events.json',
    async: false,
    dataType: 'json',
    success: function (json) {
      data = json;
    }
  });

  var barWidth = 40;
  var width = (barWidth + 10) * data.length;
  var height = 300;

  var x = d3.scale.linear().domain([0, data.length]).range([0, width]);
  var y = d3.scale.linear().domain([0, d3.max(data, function(datum) { return datum.total; })])
                            .rangeRound([0, height]);

  var svg = d3.select("#visTaxis")
    .append("svg:svg")
    .attr("width", width)
    .attr("height", height);

  svg.selectAll('rect')
    .data(data)
    .enter()
    .append('svg:rect')
    .attr("x", function(datum, index) { return x(index); })
    .attr("y", function(datum) { return height - y(datum.total); })
    .attr("height", function(datum) { return y(datum.total); })
    .attr("width", barWidth)
    .attr("fill", "#2d578b");

  svg.selectAll("text")
    .data(data)
    .enter()
    .append("svg:text")
    .attr("x", function(datum, index) { return x(index) + barWidth; })
    .attr("y", function(datum) { return height - y(datum.total); })
    .attr("dx", -barWidth/2)
    .attr("dy", "1.2em")
    .attr("text-anchor", "middle")
    .text(function(datum) { return datum.total;})
    .attr("fill", "white");

  svg.selectAll("text.yAxis")
    .data(data)
    .enter().append("svg:text")
    .attr("x", function(datum, index) { return x(index) + barWidth; })
    .attr("y", height)
    .attr("dx", -barWidth/2)
    .attr("text-anchor", "middle")
    .attr("style", "font-size: 12; font-family: Helvetica, sans-serif;")
    .text(function(datum) { return datum.car;})
    .attr("transform", "translate(0, 18)")
    .attr("class", "yAxis");
});