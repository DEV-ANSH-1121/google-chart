<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Trip;
use DB;

class ChartController extends Controller
{
	/**
	*
	* Retreives quotation of trips
	*
	* @param string $filter (week,month,year)
	* @return array List of quotations
	*
	*/
    public function getQuotation($filter='week')
    {
    	$dates = $this->getDates($filter);
    	$start_date = $dates['start_date'];
    	$end_date = $dates['end_date'];
    	$quotations = Trip::where('trip_type',1)
    					->select(
    						DB::raw('status as status'),
    						DB::raw('count(*) as count')
    					)
    					->whereBetween('booking_date', [$start_date, $end_date])
    					->groupBy('status')
    					->get();

    	$quotationsArr = array(['Status','Count']);
    	$inDiscussion = 0;
    	$accepted = 0;
    	$rejected = 0;
    	foreach($quotations as $key => $value){
    		if($value->status == 1){
    			$status = 'In Discussion';
    			$inDiscussion++;
    		}elseif($value->status == 2){
    			$status = 'Accepted';
    			$accepted++;
    		}else{
    			$status = 'Rejected';
    			$rejected++;
    		}
    		$quotationsArr[++$key] = [$status, $value->count];
    	}
    	if($inDiscussion == 0){
    		$quotationsArr[] = ['In Discussion', 0];
    	}
    	if($accepted == 0){
    		$quotationsArr[] = ['Accepted', 0];
    	}
    	if($rejected == 0){
    		$quotationsArr[] = ['Rejected', 0];
    	}

    	return ['quotes'=>$quotationsArr];
    }

    /**
	*
	* Retreives list of trips
	*
	* @param string $filter (week,month,year)
	* @return array List of trip
	*
	*/
    public function getTrip($filter='week')
    {
    	$dates = $this->getDates($filter);
    	$start_date = $dates['start_date'];
    	$end_date = $dates['end_date'];
    	$trips = Trip::where('trip_type',2)
					->select(
						DB::raw('trip_status as trip_status'),
						DB::raw('count(*) as count')
					)
					->whereBetween('trip_date', [$start_date, $end_date])
    				->groupBy('trip_status')
    				->get();

    	$tripArr = array(['Status','Count']);
    	$started = 0;
    	$completed = 0;
    	$rejected = 0;
    	foreach($trips as $key => $value){
    		if($value->trip_status == 1){
    			$trip_status = 'Started';
    			$started++;
    		}elseif($value->trip_status == 2){
    			$trip_status = 'Completed';
    			$completed++;
    		}else{
    			$trip_status = 'Rejected';
    			$rejected++;
    		}
    		$tripArr[++$key] = [$trip_status, $value->count];
    	}

    	if($started == 0){
    		$tripArr[] = ['Started', 0];
    	}
    	if($completed == 0){
    		$tripArr[] = ['Completed', 0];
    	}
    	if($rejected == 0){
    		$tripArr[] = ['Rejected', 0];
    	}

    	return ['trip'=>$tripArr];
    }

    /**
	*
	* Retreives booking and commission
	*
	* @param string $filter (week,month,year)
	* @return array List of booking and commission
	*
	*/
    public function getbookingCommission($filter='week')
    {
    	$dates = $this->getDates($filter);
    	$start_date = $dates['start_date'];
    	$end_date = $dates['end_date'];

    	$cost = Trip::select('trip_name','booking_cost','commission_cost','trip_date')
    					->get();

    	$costArr = array(['Trip', 'Booking Cost', 'Commission']);
    	foreach($cost as $key => $value){
    		if (($value->trip_date >= $start_date) && ($value->trip_date <= $end_date)){
			    $costArr[++$key] = [$value->trip_name, $value->booking_cost, $value->commission_cost];
			}else{
			    $costArr[++$key] = [$value->trip_name, 0, 0];
			}
    		
    	}

    	return ['cost'=>$costArr];
    }

    /**
	*
	* Retreives sales performace of each month of trips
	*
	* @param string $filter (booking date,trip date)
	* @return array Sales list
	*
	*/
    public function getSale($filter='booking')
    {
    	$sales = Trip::select(
						DB::raw('SUM(booking_cost) as booking_cost'),
						DB::raw('MONTH('.$filter.'_date) as month_no')
					)
    				->groupBy(DB::raw('MONTH('.$filter.'_date)'))
    				->get();
    				//return $sales;
    	$salesArr = array(['Month','Sale']);

    	for ($month=1; $month <=12 ; $month++) { 
    		$salesArr[$month] = [date('F', mktime(0, 0, 0, $month, 10)), 0];
    	}

    	foreach($sales as $key => $value){
    		$salesArr[$value->month_no] = [date('F', mktime(0, 0, 0, $value->month_no, 10)), $value->booking_cost];
    	}
    	return ['sales'=>$salesArr];
    }

    /**
	*
	* Retreives Start and end date
	*
	* @param string $filter (week,month,year)
	* @return array Start and end date
	*
	*/
    public function getDates($filter='week')
    {
    	if($filter == 'month'){
		    $start_date = date('Y-m-01', strtotime(date('Y-m-d')));
		    $end_date = date('Y-m-t', strtotime(date('Y-m-d')));
    	}elseif($filter == 'year'){
    		$start_date = date('Y-01-01', strtotime(date('Y-m-d')));
		    $end_date = date('Y-12-31', strtotime(date('Y-m-d')));
    	}else{
    		$ts = strtotime(date('Y-m-d'));
    		$start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
		    $start_date = date('Y-m-d', $start);
		    $end_date = date('Y-m-d', strtotime('next saturday', $start));
    	}

    	return ['start_date' => $start_date, 'end_date' => $end_date];
    }
}
