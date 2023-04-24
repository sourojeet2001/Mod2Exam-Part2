<?php
session_start();
include("NameDetails.php");
// Initializing object of NameDetails class.
$obj = new NameDetails();
// Fetching all the uploaded data.
$q2 = $obj->showData("Uploads");
$q2->setFetchMode(PDO::FETCH_ASSOC);

$players = $_POST['players'] ?? [];
$batsmenSelected = 0;
$allroundersSelected = 0;
$bowlersSelected = 0;
$totalPoints = 0;
// Looping through the players array to count the no of batsman, bowler and allrounders.
foreach ($players as $playerId) {
  $playerDetails = $q2->fetchById($playerId);
  $totalPoints += (int) $playerDetails['EmpPoint'];
  if ($playerDetails['EmpType'] === 'Batsman') {
    $batsmenSelected++;
  } 
  elseif ($playerDetails['EmpType'] === 'Allrounder') {
    $allroundersSelected++;
  } 
  elseif ($playerDetails['EmpType'] === 'Bowler') {
    $bowlersSelected++;
  }
}

if (count($players) !== 11 || $batsmenSelected !== 5 || $allroundersSelected !== 2 || $bowlersSelected !== 4 || $totalPoints > 100) {
  // Team is incomplete or invalid, redirect back to user.php with an error message
  $_SESSION['error_message'] = 'Please select 5 Batsmen, 2 Allrounders, and 4 Bowlers with a total of 100 or less points.';
  $obj->redirect("user.php");
  exit;
}

// Saving the selected players to the database
$selectedPlayers = [];
foreach ($players as $playerId) {
  $playerDetails = $q2->fetchById($playerId);
  $selectedPlayers[] = [
    'EmpId' => $playerDetails['EmpId'],
    'EmpName' => $playerDetails['EmpName'],
    'EmpType' => $playerDetails['EmpType'],
    'EmpPoint' => (int) $playerDetails['EmpPoint'],
  ];
}
$obj->saveTeam($selectedPlayers);

?>