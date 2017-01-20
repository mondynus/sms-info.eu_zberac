<?php
include 'conf/connect.php';

if (validateDate($_GET["date"])) {
    $date = str_replace("T"," ",$_GET["date"]);
} else {
    $today = new DateTime();
    $today->setTime(0, 0);
    $date = $today->format('Y-m-d H:i:s');
}
$sql = "SELECT * FROM announcements WHERE a_date> '" . $date . "' ORDER BY a_date DESC ";

if (intval($_GET["limit"]) > 0) {
    $sql .= "LIMIT ".intval($_GET["limit"]);
}

$out = array();
foreach ($conn->query($sql) as $row) {

    $out[]=new announcement($row["a_date"],$row["a_message"],$row["a_type"]);
}

class announcement
{
    public $date;
    public $message;
    public $type;

    function __construct($date, $message, $type)
    {
        $this->date=$date;
        $this->message=$message;
        $this->type=$type;
    }

}

function validateDate($date, $format = 'Y-m-d\TH:i:s')
{
    $d = DateTime::createFromFormat($format, $date);
    return $d && $d->format($format) == $date;
}
header('Content-Type: application/json; charset=utf-8');
echo json_encode($out,JSON_PRETTY_PRINT);

?>


