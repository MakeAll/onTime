<?php

INCLUDE "nodes/auth.php";
INCLUDE "nodes/db_connection.php";

if (!$link) {
  print "Looks like something is broken<!--Propably in the db connection-->";
  die();
}

//select and store query of all entries, order by project by date and by time
$sql1 = "SELECT * FROM `angelaj2_qs`.`tt` ORDER BY `tt`.`date` ASC, `tt`.`time` ASC ";
$entries = mysql_query($sql1);

//select and store dates in query
$sql2 = "SELECT DISTINCT `date` FROM `angelaj2_qs`.`tt` ORDER BY `tt`.`date` DESC ";
$dates = mysql_query($sql2);

//select and store projects in query
$sql3 = "SELECT DISTINCT `project` FROM `angelaj2_qs`.`tt` ORDER BY `tt`.`project` ASC ";
$projects = mysql_query($sql3);

$projectTotal = array();

for ($i = 0; $i < mysql_numrows($projects); $i++){
  $push = mysql_result($projects, $i, "project");
  $projectTotal[$push] = 0;
}

?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">

  <title>On Time</title>

  <meta name="description" content="This can be a longer description of what you are doing." />
  <meta name="keywords" content="fun, short, sometimes two, word descriptions" />

	<link rel="author" type="text/plain" href="humans.txt" />
  
  <link rel="shortcut icon" href="http://crisnoble.com/favicon.ico" type="image/x-icon" /> 

<!--   <link rel="stylesheet" href="css/reset.css"> -->
  <link rel="stylesheet" href="css/style.css">
  <script src="js/jquery-1.9.1.min.js"></script>
  <!-- <script src="js/custom.js"></script>-->
  <script>
  $(document).ready(function(){
    $('#entries').hide();
    $('#moreDates').hide();
    $('.dateTotal').hide();

    sortProjectsByTotals();

    $('#entryToggle').click(function(){
      $('#entries').toggle();
    });
    $('#rollupToggle').click(function(){
      $('#rollups').toggle();
    });
    $('#moreDatesToggle').click(function(){
      $('#moreDates').toggle();
      $(this).remove();
    });
    $('.dateDetails').hide();
    $('.dateDetailToggle').click(function(){
      if($(this).hasClass('more')){
        $(this).parent().next().toggle();
        $(this).text('-');
        $(this).removeClass('more');
        $(this).addClass('less');
      } else {
        $(this).parent().next().toggle();
        $(this).text('+');
        $(this).addClass('more');
        $(this).removeClass('less');    
      }
    });
    $('.dateDetailToggle:first').click();
    $('.dateDetailToggle')[1].click();
    $('.box').hover(function(){
      discoStop();
      $(this).css('opacity',1);
    },function(){
      discoStart();
      $(this).css('opacity',1);
    });
    randomize();

    $('.stop').click(function(){
      var project = $(this).attr('data-project');
      startStopProject(project, 'stop');
    });

    $('.start').click(function(){
      var project = $(this).attr('data-project');
      startStopProject(project, 'start');
    });

  });
  function disco(){
    $('.box').each(function(){
      var random = Math.round(Math.random()*100)/1000;
      var current = $(this).css('opacity');
      newOpacity = random*10;
      $(this).animate({'opacity':newOpacity},40);
    });
  }
  function randomize() {
    $('.box').each(function(){
      var random = Math.round(Math.random()*100)/100;
      $(this).animate({'opacity':random},100);
    });
  }
  function discoStart(){
    disco();
    console.log('lets party');
  }
  function discoStop(){
    disco();
  }

  function refreshPage(){
    window.location.href = window.location.href;
  }

  function startStopProject(project, eventType){
    $.ajax({
      type: "POST",
      url: "http://crisnoble.com/qs/ontime/nodes/timeEntry.php",
      data: {project: project, startstop: eventType}
    })
    .done(function(){
        refreshPage();
    });

  }

  function sortProjectsByTotals() {
    var totals = [];
    $('.projectRollup').each(function(){
      var number = $(this).data('projecttotal');
      totals.push(parseFloat(number));
    });
    totals = totals.sort(function(a,b){return b-a;});
    console.log(totals);
    for (var i=0; i < totals.length; i++){
      $('[data-projecttotal="'+totals[i]+'"]').appendTo('#rollups');
    }
  }

  </script>
</head>

<body>
  <h2>On Time</h2>
  <div class="week">
    <span class="box rank_90">&#x25A0;</span>
    <span class="box rank_80">&#x25A0;</span>
    <span class="box rank_50">&#x25A0;</span>
    <span class="box rank_30">&#x25A0;</span>
    <span class="box rank_20">&#x25A0;</span>
    <span class="box rank_80">&#x25A0;</span>
    <span class="box rank_10">&#x25A0;</span>
    <span class="box rank_20">&#x25A0;</span>
    <span class="box rank_40">&#x25A0;</span>
  </div>
  <div class="week">
    <span class="box rank_70">&#x25A0;</span>
    <span class="box rank_80">&#x25A0;</span>
    <span class="box rank_90">&#x25A0;</span>
    <span class="box rank_80">&#x25A0;</span>
    <span class="box rank_60">&#x25A0;</span>
    <span class="box rank_40">&#x25A0;</span>
    <span class="box rank_30">&#x25A0;</span>
    <span class="box rank_20">&#x25A0;</span>
    <span class="box rank_20">&#x25A0;</span>
  </div>
  <div class="week">
    <span class="box rank_50">&#x25A0;</span>
    <span class="box rank_70">&#x25A0;</span>
    <span class="box rank_30">&#x25A0;</span>
    <span class="box rank_90">&#x25A0;</span>
    <span class="box rank_20">&#x25A0;</span>
    <span class="box rank_20">&#x25A0;</span>
    <span class="box rank_10">&#x25A0;</span>
    <span class="box rank_40">&#x25A0;</span>
    <span class="box rank_70">&#x25A0;</span>
  </div>

  <br/>
  <!--
  <a href="javascript:(function(e,a,g,h,f,c,b,d){if(!(f=e.jQuery)||g>f.fn.jquery||h(f)){c=a.createElement('script');c.type='text/javascript';c.src='//ajax.googleapis.com/ajax/libs/jquery/'+g+'/jquery.min.js';c.onload=c.onreadystatechange=function(){if(!b&&(!(d=this.readyState)||d=='loaded'||d=='complete')){h((f=e.jQuery).noConflict(1),b=1);f(c).remove()}};a.documentElement.childNodes[0].appendChild(c)}})(window,document,'1.9.0',function($,L){var project = window.prompt('Project Name','');var eventType = window.confirm('Ok for start, Cancel for stop.'');if (eventType == true) {eventType = 'start';} else if (eventType == false) {eventType = 'stop';}if (project != null && project != null) {$.ajax({type: 'POST',url: 'http://crisnoble.com/qs/ontime/nodes/timeEntry.php',data: {project: project, startstop: eventType}}).done(function(){alert('finished');});}});">Drag me, le bookmarklet.</a>
  <br/>  
  Ideas: (0)Make Bookmarklet work (1) Make each entry editable and deleteable, (2) create calender heatmap (3) color per project
  <br>
  <span class="controls">
    <span class="tools">&#9874;</span>
    <span class="info">&#8505;</span>
    <span class="more">&#8230;</span>
    <span class="split icon">&#8916;</span>&#x29BB;&#x25B6;&#x2B21;&#x2B1C;⊗
  </span>-->
  <h3>Dates</h3>
  <?php
  //loop thru dates and spit them out
    for ($i = 0; $i < mysql_numrows($dates); $i++){
      $date = mysql_result($dates, $i, "date");
      $dow = substr(date("D", strtotime($date)),0,2)." ";
      if ($i == 7){
        print '<h4 id="moreDatesToggle">Show More Dates...</h4><div id="moreDates">';
      }
      print '<h4><span class="icon more dateDetailToggle bigger">+</span>&nbsp;'.$dow.$date.'</h4>';
      //print '<span class="dateDetails">&nbsp;&nbsp;------___---------_&#9679;&#9679;&#9679;_&#9675;&#9675;&#9675;&#9675;&#9675;--------------------------------------------------------------------<br/></span>';
      print '<div class="dateDetails">';
      $subQuery = "SELECT DISTINCT `project` FROM `angelaj2_qs`.`tt` WHERE `tt`.`date` = '$date' ORDER BY `tt`.`time` ASC ";
      $projectsOnDate = mysql_query($subQuery);
      $dateTotal = 0;
      for ($j = 0; $j < mysql_numrows($projectsOnDate); $j++){
        $projectOnDate = mysql_result($projectsOnDate, $j, "project");
        print '&nbsp;&nbsp;<span class="bullet">&#11044;</span>&nbsp;&nbsp;'.$projectOnDate.': ';
        $subQuery2 = "SELECT * FROM `angelaj2_qs`.`tt` WHERE `tt`.`project` = '$projectOnDate' AND `tt`.`date` = '$date' ORDER BY `tt`.`time` ASC";
        $entriesByProjectOnDate = mysql_query($subQuery2);
        $numEntries = mysql_numrows($entriesByProjectOnDate);
        $totalHours = 0;
        $active = false;
        for ($k = 0; $k < $numEntries; $k++) {
          // if ($k % 2 == 0 && $k > 1) {
          //   print "&nbsp;\t&nbsp;\t&nbsp;\t&nbsp;\t";
          // }
          if (mysql_result($entriesByProjectOnDate, $k, "startstop") == 'start') {  
            if ($numEntries % 2 == 1 && $numEntries == $k + 1) {
              $startTime = mysql_result($entriesByProjectOnDate, $k, "time");
              $now = date("H:i:s",time()+60*60); //NEED TO FIGURE OUT NOW
              $interval = round((strtotime($now) - strtotime($startTime))/3600, 2);

              $totalHours = $totalHours + $interval;
              $active = true;
              $projectTotal[$projectOnDate] += $interval;
              // print ' hours';
              // print '(active)<br/>';
            }
          } else {
            $thisTime = mysql_result($entriesByProjectOnDate, $k, "time");
            $previousTime = mysql_result($entriesByProjectOnDate, $k - 1, "time");
            $interval = round((strtotime($thisTime)-strtotime($previousTime))/3600, 2);
            $totalHours = $totalHours + $interval;
            $projectTotal[$projectOnDate] += $interval;
            // print ' hours<br>';
          }
        }
        print $totalHours.' hrs';
        $dateTotal += $totalHours;
        if ($active) {
          print ' <span class="stop icon" data-project="'.$projectOnDate.'">&#9632;</span>';
        }
        print "<br/>";
      }
      print '</div>';
      print '<span class="dateTotal" data-date="'.$date.'" date-datetotal="'.$dateTotal.'">'.$dateTotal.'</span>';
      //print '</div>';
      if($i == mysql_numrows($dates) - 1){
        print "</div>";
      }
    }
  ?>
  <h3 id="rollupToggle">Project Rollups</h3>
  <div id="rollups">
  <?php
  //loop thru projects and spit them out
    for ($i = 0; $i < mysql_numrows($projects); $i++){
      $project = mysql_result($projects, $i, "project");
      print '<div class="projectRollup" data-projecttotal="'.$projectTotal[$project].'">';
      print '<span class="start icon" data-project="'.$project.'">▶  </span>';
      print $project.": ".$projectTotal[$project]." hrs";
      print '</div>';
    }
  ?>
  </div>
  <h3 id="entryToggle">Entry Details</h3>
  <div id="entries">
  <?php
  //loop thru all entries, spit them out
    for ($i = 0; $i < mysql_numrows($entries); $i++){

      $entry = mysql_result($entries, $i, "project");
      $date = mysql_result($entries, $i, "date");
      $time = mysql_result($entries, $i, "time");
      $event = mysql_result($entries, $i, "startstop");
      $id = mysql_result($entries, $i, "id");

      print '<span data-id="'.$id.'">';
      print $entry." | ".$date." | ".$time." | ".$event;
      print '</span>';
      print '<br/>';
    }
  ?>
  </div>
  <br/>  
  Ideas: (0)Make Bookmarklet work (1) Make each entry editable and deleteable, (2) create calender heatmap (3) color per project, (5) Start new project from page
  <br>

</body>
</html>
<?php
  //close up
  mysql_close($link);
?>