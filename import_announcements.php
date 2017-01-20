<?php
include 'conf/connect.php';

//check last date
$sql = "SELECT a_date FROM announcements ORDER BY a_date DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$row = $stmt->fetch();
$last_date="2016-11-11 14:30:01";
$last_date = $row["a_date"];


//get announcements
$ch = curl_init();
$villageid=""; //ID obce v https://sms-info.eu/. Vyberte obec a nasledne kliknite na archiv oznamov. Vase id sa objavi v URL linke
curl_setopt($ch, CURLOPT_URL, "https://sms-info.eu/API/getMessagesByClient");
curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_POSTFIELDS, "id=".$villageid."&date=" . $last_date);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$server_output = curl_exec($ch);
curl_close($ch);
// further processing ....
$oznamy = json_decode($server_output);


$stmt = $conn->prepare("INSERT IGNORE INTO announcements (a_hash,a_message,a_date,a_type) 
    VALUES (:hash, :message, :date,:type)");
$stmt->bindParam(':hash', $data_hash);
$stmt->bindParam(':message', $data_message);
$stmt->bindParam(':date', $data_date);
$stmt->bindParam(':type', $data_type);

if (count($oznamy->data->messages) > 0) {
    $i=0;
    foreach ($oznamy->data->messages as $message) {
        $data_hash=sha1($message->message.$message->date);
        $data_message=$message->message;
        $data_date=$message->date;
        $data_type=$message->theme;
        $stmt -> execute();
        $i ++;
    }

    echo $i." announcements added";
} else {
    echo "no data imported";
}

?>