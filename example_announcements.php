<html xmlns="http://www.w3.org/1999/html">
<head>
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
</head>
</body>
<?php
$today = new DateTime('7 days ago');
$today->setTime(0, 0);
//echo $today->format('Y-m-d H:i:s');
include 'conf/connect.php';
$sql = "SELECT * FROM announcements WHERE a_date> '" . $today->format('Y-m-d H:i:s') . "' ORDER BY a_date DESC";

$none=true;
$i=0;

foreach ($conn->query($sql) as $row) {
    $none=false;
    if ($_GET['mini']) {
        echo "<p><strong>" . getSlovakDateFormat($row["a_date"]) . ":</strong> " . $row["a_message"] . "</p>";
        if ($i > 1) {
            break;
        }
    } else {
        echo "<div><p> " . getSlovakDateFormat($row["a_date"]) . "</p><p>" . $row["a_type"] . "</p><p>" . $row["a_message"] . "</p></div>";
    }

    $i += 1;
}

function getSlovakDateFormat($sql_date){

    $date=DateTime::createFromFormat('Y-m-d H:i:s', $sql_date);
    return $date->format('d.m.Y H:i');
}


if ($none == true) {
    echo "<p class=\"item_description\">Dnes neboli vyhlásené žiadne oznamy<div>";
}
?>
</body>
</html>

