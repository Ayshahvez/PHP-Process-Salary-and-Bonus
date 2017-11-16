<?php
//written by: Ayshahvez Konowalchuk
//php code to process Salary and bonus payments dates for next upcoming 12 months

// also a command line utility, where it can be executed on command line
//add path to php as environment variable or set system path to php
// navigate to the folder which contains the demo.php then  run it as= php demo.php
//OTHERWISE just open it with any browser and the csv file will be downloaded automatically
//you may have to resize the columns to a larger size for the dates to be displayed
									 					 
class ProcessPaymentDates{//class contains all methods and properties used to produce csv file
	
public function ProcessCSVFile(){
		// output headers so that the file is downloaded rather than displayed
	header('Content-type: text/csv');
	header('Content-Disposition: attachment; filename="dates.csv"');
 
	// do not cache the file
	header('Pragma: no-cache');
	header('Expires: 0');
 
	// create a file pointer connected to the output stream
	$file = fopen('php://output', 'w');
 
	// send the column headers
	fputcsv($file, array('Month', 'Salary Payment Date', 'Bonus Payment Date'));
	// Close the file
fclose($file);
}
	
public function getCurrentDate(){
	$now = new DateTime(date('M-d-Y'));// get current computer date 
	$period = new DatePeriod($now, new DateInterval('P1M'), 11);  // set period of date to get next 12 months
	return $period;
}

public function ProcessDates(){//function used to get data values for month, day, year
	$Cperiod = ProcessPaymentDates::getCurrentDate();//get current date values from computer
		foreach ($Cperiod as $date){	

			$m = date_format($date, 'M');  //get month value
			$t = date_format($date, 't');  //get day value
			$y = date_format($date, 'Y');  //get year value
		
			ProcessPaymentDates::ProcessSalaryDate($m,$t,$y);
			ProcessPaymentDates::ProcessBonusDate($m,$t,$y);	
	}//end function getDate
}
	
public function ProcessBonusDate($m, $d, $y){//function to process Dates for bonus payment
//format to put date in = '2011-01-01';
	$d=15; //day is set to default 15 for payment day
	$date = "$y-$m-$d"; //store date as string value in $date variable
	$date1 = strtotime($date); //converts string value in $date to data type of date
	$date2 = date("l", $date1); //return day from the date to variable $date2

	$date3 = strtolower($date2);//converts to lowercase
	$tmp = $date3;
	// if day is saturday then add 3 to make it to next wednesday
	if ($date3 == "saturday") {
		// echo "true";
		$d  += 4;
		$tmp = 'wednesday';

		// if day is sunday then add 3 to make it to the nexr wednesday   
	} elseif ($date3 == "sunday"){
			//   echo "false";
			$d  += 3;
			$tmp = 'wednesday';
			}
$date3 = $tmp;
echo " $m-$d-$y \n";  //output to cvs file
}


public function ProcessSalaryDate($m,$d,$y){//function to process dates for salary dates payment
	//format to put date in = '2011-01-01';
	$date = "$y-$m-$d";
	$date1 = strtotime($date); 
	$date2 = date("l", $date1);
	$month = date("F", $date1);

	$date3 = strtolower($date2);
	$tmp = $date3;
	// if day is saturday then minus 1 from the day
	if ($date3 == "saturday") {
		// echo "true";
		$d  -= 1;
		$tmp = 'friday';
	// if day is sunday then minus 2 from the day
	}elseif ($date3 == "sunday") {
		//   echo "false"
		$d -= 2;
		$tmp = 'friday';
	}

	$date3 = $tmp;
	echo "$month, $m-$d-$y,"; //output to cvs file
}

}//end of class


//BEGIN PROCESSING
ProcessPaymentDates::ProcessCSVFile(); //call to function ProcessCVSFile()
ProcessPaymentDates::ProcessDates();
//$Payment = new ProcessPaymentDates; //
//$Payment->ProcessDates();
exit();
?>