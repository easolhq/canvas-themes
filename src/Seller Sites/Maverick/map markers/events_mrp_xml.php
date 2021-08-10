<?php require_once('../Connections/connUKCE.php');?>
<?php
function parseToXML($htmlStr)
{
$xmlStr=str_replace('<','',$htmlStr);
$xmlStr=str_replace('>','',$xmlStr);
$xmlStr=str_replace('"','&quot;',$xmlStr);
$xmlStr=str_replace("'",'&#39;',$xmlStr);
$xmlStr=str_replace("&",'&amp;',$xmlStr);
$xmlStr=str_replace("br /",'',$xmlStr);
$xmlStr=str_replace("br/",'',$xmlStr);
return $xmlStr;
}


// Select all the rows in the markers table
$query = "SELECT event_id,event_title,event_location,event_venue_lat,event_venue_long,event_discipline,event_small_logo,event_url, event_brand, run_leader_name,  DATE_FORMAT(event_date,'%d %M %Y') AS event_date_format FROM mrp_events WHERE event_live='Y' AND event_listings='Y' AND event_closed = 'No' ORDER BY event_location ASC";
$result = mysqli_query($connect, $query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

header("Content-type: text/xml");

// Start XML file, echo parent node
echo '<markers>';

// Iterate through the rows, printing XML nodes for each
while ($row = @mysqli_fetch_assoc($result)){
  // Add to XML document node
  echo '<marker ';
  echo 'event_id="' . $ind . '" ';
  echo 'event_title="' . parseToXML($row['event_title']) . '" ';
  echo 'event_location="' . parseToXML($row['event_location']) . '" ';
  echo 'run_leader_name="' . parseToXML($row['run_leader_name']) . '" ';
  echo 'event_url="' . parseToXML($row['event_url']) . '" ';
  echo 'event_small_logo="' . parseToXML($row['event_small_logo']) . '" ';
  echo 'event_brand="' . $row['event_brand'] . '" ';
  echo 'event_venue_lat="' . $row['event_venue_lat'] . '" ';
  echo 'event_venue_long="' . $row['event_venue_long'] . '" ';
  echo '/>';
}

// End XML file
echo '</markers>';

?>