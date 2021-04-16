//Reloads chart on change in filter
$(document).on('change','.quotationFilter',function(){
    quotationDonutChart($(this).find(":selected").val());
});
$(document).on('change','.tripFilter',function(){
    tripDonutChart($(this).find(":selected").val());
});
$(document).on('change','.bookCommFilter',function(){
    bookCommBarChart($(this).find(":selected").val());
});
$(document).on('change','.saleFilter',function(){
    salesLineChart($(this).find(":selected").val());
});


// Load the Visualization API and the corechart package.
google.charts.load('current', {'packages':['corechart','bar']});
// Set a callback to run when the Google Visualization API is loaded.
google.charts.setOnLoadCallback(quotationDonutChart);
google.charts.setOnLoadCallback(tripDonutChart);
google.charts.setOnLoadCallback(bookCommBarChart);
google.charts.setOnLoadCallback(salesLineChart);
// Callback that creates and populates a data table,
// instantiates the charts, passes in the data and
// draws it.
function quotationDonutChart(filter='week') {
    // Create the data table.
    $.ajax({
        url : window.location.origin+window.location.pathname+'get-quotation/'+filter,
        method : 'get',
        success : function(response){
            var data = new google.visualization.arrayToDataTable(response.quotes);
            // Set chart options
            var options = {'title':'Quotations Donut Chart',
                'width':'50%',
                'pieHole': 0.4,
                'sliceVisibilityThreshold' :0
            };
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('quotationDonutChart'));
            chart.draw(data, options);
        }
    });
}

function tripDonutChart(filter='week') {
    // Create the data table.
    $.ajax({
        url : window.location.origin+window.location.pathname+'get-trip/'+filter,
        method : 'get',
        success : function(response){
            var data = new google.visualization.arrayToDataTable(response.trip);
            // Set chart options
            var options = {'title':'Trips Donut Chart',
                'width':'50%',
                'pieHole': 0.4,
                'sliceVisibilityThreshold' :0
            };
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('tripDonutChart'));
            chart.draw(data, options);
        }
    });
}

function bookCommBarChart(filter='week') {
    // Create the data table.
    $.ajax({
        url : window.location.origin+window.location.pathname+'get-booking-commision/'+filter,
        method : 'get',
        success : function(response){
            var data = new google.visualization.arrayToDataTable(response.cost);
            // Set chart options
            var options = {
                chart: {
                    title: 'Booking & Commission Bar Chart'
                },
                'width' : '50%',
                'bar': { 'groupWidth': "20%" },
                'sliceVisibilityThreshold' :0
            };

            var chart = new google.charts.Bar(document.getElementById('bookCommBarChart'));

            chart.draw(data, google.charts.Bar.convertOptions(options));
        }
    });
}

function salesLineChart(filter='booking') {
    // Create the data table.
    $.ajax({
        url : window.location.origin+window.location.pathname+'get-sales/'+filter,
        method : 'get',
        success : function(response){
            var data = new google.visualization.arrayToDataTable(response.sales);
            // Set chart options
            var options = {
                'title':'Sales Line Chart',
                'width':'50%',
                'sliceVisibilityThreshold' :0
            };
            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.LineChart(document.getElementById('salesLineChart'));
            chart.draw(data, options);
        }
    });
}

