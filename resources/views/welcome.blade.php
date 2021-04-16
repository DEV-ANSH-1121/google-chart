<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <!-- Styles -->
        <style>
        </style>
    </head>
    <body>
        <div class="container">
            <div class="row text-center">
                <div class="col-12">
                    <h1 id="dd">Brain Inventory Test Task</h1>
                </div>
                <div class="col-12" style="border: 1px solid #fd509d; padding-top: 15px;">
                    <div class="pull-right">
                        <select class="quotationFilter">
                            <option value="week">Weekly</option>
                            <option value="month">Monthly</option>
                            <option value="year">Yearly</option>
                        </select>
                    </div>
                    <div id="quotationDonutChart" class="text-center"></div>
                </div>
                <div class="col-12" style="border: 1px solid #fd509d; padding-top: 15px;">
                    <div class="pull-right">
                        <select class="tripFilter">
                            <option value="week">Weekly</option>
                            <option value="month">Monthly</option>
                            <option value="year">Yearly</option>
                        </select>
                    </div>
                    <div id="tripDonutChart" class="text-center"></div>
                </div>
                <div class="col-12" style="border: 1px solid #fd509d; padding-top: 15px;">
                    <div class="pull-right">
                        <select class="bookCommFilter">
                            <option value="week">Weekly</option>
                            <option value="month">Monthly</option>
                            <option value="year">Yearly</option>
                        </select>
                    </div>
                    <div id="bookCommBarChart" class="text-center"></div>
                </div>
                <div class="col-12" style="border: 1px solid #fd509d; padding-top: 15px;">
                    <div class="pull-right">
                        <select class="saleFilter">
                            <option value="booking">Booking Date</option>
                            <option value="trip">Trip Date</option>
                        </select>
                    </div>
                    <div id="salesLineChart" class="text-center"></div>
                </div>
            </div>
        </div>
    </body>
    <!--Load the JQUERY CDN-->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <!--Load the BOOTSTRAP CDN-->
    <script type="text/javascript" src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript" src="{{ url('/js/google-chart.js') }}"></script>
</html>