<?php
    
    define("DRIVER_INPUT", "
               <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

               <style>
               
               input[type=button], input[type=button], input[type=reset] {
                 background-color: #4CAF50;
                 border: none;
                 color: white;
                 padding: 16px 32px;
                 text-decoration: none;
                 margin: 4px 2px;
                 cursor: pointer;
               }


               </style>

               <div id=form action='' method='POST'>
                <table>

              Were is it going? <br>
              <input type='radio' name='Drivedir' value='city'> To City &nbsp; &nbsp;
              <input type='radio' name='Drivedir' value='contryside'> To Countryside &nbsp; &nbsp;
              <br>
           
              <tr><td><input type='button' style='margin-top:5px' class='btn btn-primary' value='Save' onclick='saveData()'></td></tr>

             </table>
           </div>");
           
           
           

define("PASSENGER_INPUT", "
        <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

        <style> 
        
        input[type=button], input[type=button], input[type=reset] {
          background-color: #4CAF50;
          border: none;
          color: white;
          padding: 16px 32px;
          text-decoration: none;
          margin: 4px 2px;
          cursor: pointer;
        }        


        </style>


        <div id=form action='' method='POST'>
         <table>
       
        <tr>

        <label for='cars'>Type of Transportation:</label> <br>

        <select name='trans_type' id='trans_type'>
          <option value='Troleibus'>Troleibus</option>
          <option value='Bus'>Bus</option>
          <option value='Mini-bus'>Mini-bus</option>
        </select>

        <br>

        <tr> <td><br>
         Transportation number: <br><textarea id='trans_num'  style='resize:none' name='trans_num' rows='1' cols='10' maxlength='4'> </textarea>
         </td></tr>

        <td>
       <br>
       Were is it going? <br>
       <input type='radio' name='Passdir' value='city'> To City &nbsp; &nbsp;
       <input type='radio' name='Passdir' value='contryside'> To Countryside &nbsp; &nbsp;
       <br>
       
        <br>
        How full is it? <br>
        <input type='radio' name='lev' value='0'> 20% &nbsp; &nbsp;
        <input type='radio' name='lev' value='1'> 60% &nbsp; &nbsp;
        <input type='radio' name='lev' value='3'> 100% &nbsp; &nbsp;
        <br>

        </td></tr>
       
        <tr><td><input type='button' style='margin-top:5px' class='btn btn-primary' value='Save' onclick='saveData()'></td></tr>

      </table>
    </div>");
       
    $pass_input = file_get_contents('./pass_input.html');
       
define("DRIVER_INPUT", "
           <meta http-equiv='Content-Type' content='text/html; charset=utf-8' />

           <style>
           
           input[type=button], input[type=button], input[type=reset] {
             background-color: #4CAF50;
             border: none;
             color: white;
             padding: 16px 32px;
             text-decoration: none;
             margin: 4px 2px;
             cursor: pointer;
           }


           </style>

           <div id=form action='' method='POST'>
            <table>

          Were is it going? <br>
          <input type='radio' name='Drivedir' value='city'> To City &nbsp; &nbsp;
          <input type='radio' name='Drivedir' value='contryside'> To Countryside &nbsp; &nbsp;
          <br>
       
          <tr><td><input type='button' style='margin-top:5px' class='btn btn-primary' value='Save' onclick='saveData()'></td></tr>

         </table>
       </div>");


define("MESSAGE_LOCATION_SAVED", "<div id='message'>Location saved</div>");

function logAction($conn, $a, $b) {
        mysqli_query($conn, "INSERT into logAction (uname, status, attempt_date) values ('$a', '$b', now());"); 
}

function filterInput($input)
{
        $cinput = preg_replace('/\'/','',$input);
        $cinput = preg_replace('/\"/','',$cinput);
        $cinput = preg_replace('/\</','',$cinput);
        $cinput = preg_replace('/\>/','',$cinput);
        $cinput = preg_replace('/script/','',$cinput);
        $cinput = preg_replace('/javascript/','',$cinput);

        return $cinput;
}

function ipVerification($ip) {

	$conn = mysqli_connect("localhost","kushtar","kushtar", "kushtar");

	$user_arr = mysqli_query($conn, "SELECT * from Users where ip = '$ip'");
	$row=mysqli_fetch_array($user_arr,MYSQLI_ASSOC);
	return $row['id'];
}


$conn = mysqli_connect("localhost","kushtar","kushtar", "kushtar");


function htmlGetBack ($prob, $link, $message) {
	if($prob != "") {
	print("<html>
    <head>
     <link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css'>
  <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js'></script>
  <script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js'></script>
  </head>
	<h1><center>$prob</center></h1>
	<br>
	</html>
	");
	}
	print ("
	<html>
	<hr>
<center>	<a href = '$link' class='btn btn-success'> $message </a> </center>
	</html>
	");
}
$bishkek = array(
"42.868969, 74.464751
","42.908480, 74.524833
","42.960291, 74.593266
","42.942886, 74.643088
","42.866531, 74.718477
","42.845668, 74.705018
","42.796170, 74.625362
","42.805535, 74.556394
","42.825685, 74.510408
","42.858406, 74.464726
","42.868969, 74.464751
");

/*$bishkek = array(
"42.858342 74.465001
","42.868974 74.465090
","42.869350 74.475477
","42.864946 74.475732
","42.867276 74.501395
","42.874950 74.500539
","42.874589 74.512139
","42.893452 74.509394
","42.949765 74.583622
","42.942166 74.642717
","42.895647 74.630248
","42.893113 74.646039
","42.909968 74.644017
","42.909458 74.650198
","42.898641 74.651203
","42.891322 74.668700
","42.892094 74.656682
","42.881530 74.656313
","42.866838 74.718079
","42.863598 74.701930
","42.845228 74.704621
","42.855125 74.650760
","42.834616 74.651626
","42.833214 74.639011
","42.813578 74.644421
","42.807821 74.554749
","42.826458 74.510865
","42.861696 74.510075
","42.859366 74.466042
","42.858342 74.465001
");*/

$sverdlov = array(
"42.949043 74.608903
","42.863716 74.610287
","42.866465 74.628748
","42.865788 74.718754
","42.871081 74.703157
","42.870958 74.697494
","42.878378 74.696296
","42.882155 74.678277
","42.879892 74.676217
","42.881276 74.656309
","42.892217 74.656994
","42.893222 74.651329
","42.898756 74.655277
","42.898504 74.651500
","42.909697 74.650811
","42.910325 74.644286
","42.893568 74.646423
","42.894987 74.631127
","42.909749 74.630145
","42.916506 74.624797
","42.928779 74.626244
","42.927003 74.633047
","42.942481 74.642756
","42.949043 74.608903
");

$lenin = array(
"42.868970 74.465229
","42.858281 74.464946
","42.838389 74.483141
","42.825477 74.510662
","42.829920 74.518305
","42.829391 74.522493
","42.832568 74.522925
","42.830557 74.528414
","42.830982 74.537222
","42.821133 74.535925
","42.804293 74.524526
","42.810753 74.524235
","42.810857 74.518027
","42.800056 74.519476
","42.798468 74.522652
","42.803870 74.527269
","42.805566 74.535929
","42.817321 74.540113
","42.817004 74.548342
","42.813615 74.548775
","42.805567 74.556137
","42.800059 74.568837
","42.776517 74.580241
","42.776389 74.586933
","42.884027 74.588698
","42.884534 74.576159
","42.879878 74.575126
","42.874966 74.501279
","42.867163 74.501285
","42.865157 74.475543
","42.869310 74.475714
","42.868970 74.465229
");
$pervomay = array(
"42.893488 74.509789
","42.884994 74.510760
","42.884730 74.511211
","42.880953 74.511466
","42.880729 74.513048
","42.874260 74.512180
","42.874035 74.518611
","42.877922 74.560358
","42.878370 74.561736
","42.878731 74.561761
","42.880039 74.565028
","42.879774 74.575338
","42.884860 74.576311
","42.884085 74.577941
","42.883973 74.588965
","42.843686 74.585901
","42.842936 74.608713
","42.926437 74.611872
","42.929525 74.610753
","42.927970 74.605653
","42.920502 74.604863
","42.911835 74.603406
","42.911879 74.596305
","42.917035 74.596366
","42.920680 74.596244
","42.926636 74.599644
","42.932901 74.598976
","42.933612 74.594909
","42.938545 74.598308
","42.938545 74.599582
","42.940855 74.599825
","42.941966 74.597275
","42.943300 74.598186
","42.944231 74.597944
","42.950274 74.593815
","42.949562 74.581067
","42.942630 74.579309
","42.942320 74.583315
","42.945964 74.587563
","42.944942 74.589506
","42.936547 74.584599
","42.927572 74.575650
","42.910871 74.577020
","42.909337 74.557393
","42.896060 74.555725
","42.893488 74.509789
");
$oktyabr = array(
"42.843664, 74.585898
","42.799855, 74.583855
","42.799982, 74.587802
","42.802248, 74.590889
","42.803005, 74.599468
","42.805271, 74.609420
","42.802753, 74.610449
","42.802753, 74.615597
","42.803665, 74.616524
","42.808164, 74.631183
","42.809811, 74.632766
","42.810822, 74.635470
","42.812543, 74.645219
","42.817185, 74.644249
","42.832422, 74.639302
","42.833903, 74.649942
","42.841827, 74.650047
","42.845426, 74.704904
","42.866823, 74.701538
","42.868169, 74.663007
","42.867816, 74.642646
","42.866281, 74.628865
","42.863663, 74.617791
","42.863663, 74.610952
","42.842984, 74.608743
","42.843664, 74.585898
");

$polygon = array("
-50 30
","50 70
","100 50
","80 10
","110 -10
","110 -30
","-20 -50
","-30 -40
","10 -10
","-10 10
","-30 -20
","-50 30
");


/*
Description: The point-in-polygon algorithm allows you to check if a point is
inside a polygon or outside of it.
Author: Michael Niessen (2009)
Website: http://AssemblySys.com
 
If you find this script useful, you can show your
appreciation by getting Michael a cup of coffee ;)
PayPal: michael.niessen@assemblysys.com
 
As long as this notice (including author name and details) is included and
UNALTERED, this code is licensed under the GNU General Public License version 3:
http://www.gnu.org/licenses/gpl.html
*/
 
class pointLocation {
    var $pointOnVertex = true; // Check if the point sits exactly on one of the vertices?
 
    function pointLocation() {
    }
 
    function pointInPolygon($point, $polygon, $pointOnVertex = true) {
        $this->pointOnVertex = $pointOnVertex;
 
        // Transform string coordinates into arrays with x and y values
        $point = $this->pointStringToCoordinates($point);
        $vertices = array(); 
        foreach ($polygon as $vertex) {
            $vertices[] = $this->pointStringToCoordinates($vertex); 
        }
 
        // Check if the point sits exactly on a vertex
        if ($this->pointOnVertex == true and $this->pointOnVertex($point, $vertices) == true) {
            return "inside";
        }
 
        // Check if the point is inside the polygon or on the boundary
        $intersections = 0; 
        $vertices_count = count($vertices);
 
        for ($i=1; $i < $vertices_count; $i++) {
            $vertex1 = $vertices[$i-1]; 
            $vertex2 = $vertices[$i];
            if ($vertex1['y'] == $vertex2['y'] and $vertex1['y'] == $point['y'] and $point['x'] > min($vertex1['x'], $vertex2['x']) and $point['x'] < max($vertex1['x'], $vertex2['x'])) { // Check if point is on an horizontal polygon boundary
                return "inside";
            }
            if ($point['y'] > min($vertex1['y'], $vertex2['y']) and $point['y'] <= max($vertex1['y'], $vertex2['y']) and $point['x'] <= max($vertex1['x'], $vertex2['x']) and $vertex1['y'] != $vertex2['y']) { 
                $xinters = ($point['y'] - $vertex1['y']) * ($vertex2['x'] - $vertex1['x']) / ($vertex2['y'] - $vertex1['y']) + $vertex1['x']; 
                if ($xinters == $point['x']) { // Check if point is on the polygon boundary (other than horizontal)
                    return "inside";
                }
                if ($vertex1['x'] == $vertex2['x'] || $point['x'] <= $xinters) {
                    $intersections++; 
                }
            } 
        } 
        // If the number of edges we passed through is odd, then it's in the polygon. 
        if ($intersections % 2 != 0) {
            return "inside";
        } else {
            return "outside";
        }
    }
 
    function pointOnVertex($point, $vertices) {
        foreach($vertices as $vertex) {
            if ($point == $vertex) {
                return true;
            }
        }
 
    }
 
    function pointStringToCoordinates($pointString) {
        $coordinates = explode(" ", $pointString);
        return array("x" => $coordinates[0], "y" => $coordinates[1]);
    }
 
}


function logError($string) {
// $path = getcwd();
// $myfile = fopen($path . '/mylog.txt', 'a') or die("Can not open the file");
// $today = date("Y-m-d H:i:s"); 
// fwrite($myfile, "$string on $today\n");
}

$today = date("Y-m-d H:i:s"); 

