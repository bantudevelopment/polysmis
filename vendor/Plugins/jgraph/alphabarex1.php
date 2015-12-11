<?php // content="text/plain; charset=utf-8"

require_once ('jpgraph.php');
require_once ('jpgraph_bar.php');
require_once ('../../inc/common.php');
global $dbConn;

//Get programmes
$sqlProgs = sprintf("
					select 	sum(if(isRegistered = 1 and formSubmited =1,1,0)) as registered,
						sum(if(isRegistered = 0 and formSubmited =1,1,0)) as pendingconf,
						sum(if(isRegistered = 0 and formSubmited =0,1,0)) as notregistered,tbl_program.name
					from tbl_studentclass 
					join tbl_class
					on(tbl_class.id = tbl_studentclass.class_id)
					join tbl_program
					on(tbl_program.id = tbl_class.programme_id)
					where semester_id in(
						select 	Semesterid from 
						tbl_semester 
						where CURDATE() BETWEEN start_date and end_date
					)
					and academicYear_id in(
						select 	id from 
						tbl_academicyear 
						where CURDATE() BETWEEN start_date and end_date
					)
					and programLevel_id = '5'
					group by tbl_program.id
					");
$rsProgs = $dbConn->query($sqlProgs);
while($oProgs = $rsProgs->fetchRow(DB_FETCHMODE_OBJECT)){
		$registered[$oProgs->name] = $oProgs->registered;
		$pendingconf[$oProgs->name] = $oProgs->pendingconf;
		$notregistered[$oProgs->name] = $oProgs->notregistered;
}
$progs = array_keys($registered);

foreach($registered as $prog=>$register){
	$registeredArray[] = $register; 
	$pendingconfArray[] = $pendingconf[$prog];
	$notregisteredArray[] = $notregistered[$prog];
}

// Create the basic graph
$graph = new Graph(550,250,'auto');	
$graph->SetScale("textlin");
$graph->img->SetMargin(60,80,30,40);

// Adjust the position of the legend box
$graph->legend->Pos(0.02,0.15);

// Adjust the color for theshadow of the legend
$graph->legend->SetShadow('darkgray@0.4');
$graph->legend->SetFillColor('lightblue@0.4');

// Get localised version of the month names
$graph->xaxis->SetTickLabels($progs);

// Set a nice summer (in Stockholm) image
//$graph->SetBackgroundImage('stship.jpg',BGIMG_COPY);

// Set axis titles and fonts
$graph->xaxis->title->Set('Programme');
$graph->xaxis->title->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->title->SetColor('white');
$graph->yaxis->title->Set('Number');
$graph->yaxis->title->SetFont(FF_FONT1,FS_BOLD);
$graph->yaxis->title->SetMargin(20);

$graph->xaxis->SetFont(FF_FONT1,FS_BOLD);
//$graph->xaxis->SetColor('white');

$graph->yaxis->SetFont(FF_FONT1,FS_BOLD);
//$graph->yaxis->SetColor('white');

$graph->ygrid->Show(false);
$graph->ygrid->SetColor('white');

// Setup graph title
$graph->title->Set('Registration status');
// Some extra margin (from the top)
$graph->title->SetMargin(3);
$graph->title->SetFont(FF_ARIAL,FS_NORMAL,12);


// Create the three var series we will combine
$bplot1 = new BarPlot($registeredArray);
$bplot2 = new BarPlot($notregisteredArray);
$bplot3 = new BarPlot($pendingconfArray);

// Setup the colors with 40% transparency (alpha channel)
$bplot1->SetFillColor('red@0.4');
$bplot2->SetFillColor('blue@0.4');
$bplot3->SetFillColor('green@0.4');

// Setup legends
$bplot1->SetLegend('Registered');
$bplot2->SetLegend('Not registered');
$bplot3->SetLegend('Pending confirmation');

// Setup each bar with a shadow of 50% transparency
$bplot1->SetShadow('black@0.4');
$bplot2->SetShadow('black@0.4');
$bplot3->SetShadow('black@0.4');

$gbarplot = new GroupBarPlot(array($bplot1,$bplot2,$bplot3));
$gbarplot->SetWidth(0.8);

$graph->Add($gbarplot);

$graph->Stroke();
?>

