<?php
namespace Controller;

use Doctrine\DBAL\Query\QueryBuilder;

class IndexController
{
  public function indexAction()
  {
    include("../views/search.php");
  }

  public function searchAction()
  {
    header('Content-Type: application/json');


    $conn = \MovieSearch\Connexion::getInstance();



    $title = $_POST['title'];
    $duration = $_POST['duration'];
    $yearStart = $_POST['year_start'];
    $yearEnd = $_POST['year_end'];
    $timeSet = "";


    if (isset($title)) {
      $titleSet = " SELECT * FROM film WHERE title LIKE '%$title%'";
    }

    if (isset($duration)) {
      if ($duration == "all") {
        $timeSet = "";

      } else if ($duration == "lessOneHour") {
        $timeSet = " AND duration < 3600 ";

      } else if ($duration == "betweenOneAndOneHalf") {
        $timeSet = " AND duration BETWEEN 3600 AND 5400 ";

      } else if ($duration == "betweenOneHalfAndTwoHalf") {
        $timeSet = " AND duration BETWEEN 5400 AND 9000 ";

      } else if ($duration == "moreTwoHalf") {
        $timeSet = " AND duration > 9000 ";
      }
    }

    if (isset($yearStart)) {
      $yearStartSet = " AND year >= '$yearStart' ";
    }

    if (empty($yearStart)) {
      $yearStartSet = "";
    }

    if (isset($yearEnd)) {
      $yearEndSet = " AND year <= '$yearEnd' ";
    }

    if (empty($yearEnd)) {
      $yearEndSet = "";
    }
    //.'GROUP BY title'

    $stmt = $conn->prepare($titleSet . $timeSet . $yearStartSet . $yearEndSet . 'GROUP BY title');
    $stmt->execute();
    $films = $stmt->fetchAll();
      http_response_code(200);
    echo json_encode(["films" => $films]);
  }
}