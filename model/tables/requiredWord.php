<?php

namespace model\tables;

use \model\DatabaseConnection;

class RequiredWord {
  private $db;

  public function __construct() {
    $this->db = DatabaseConnection::getDatabaseConnection();
  }

  /**
   * add a required word
   * @param id - id of the competition
   * @param word - required word to add
   */
  public function addRequiredWord($id, $word) {
    $safeWord = mysqli_real_escape_string($this->db,htmlspecialchars($word));

    $queryCheck = "SELECT COUNT(*) FROM RequiredWord WHERE competition=$id AND word='$safeWord';";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $result = mysqli_fetch_array($execCheck);

    if($result['COUNT(*)'] == 0) {
      $query = "INSERT INTO requiredWord (competition, word) VALUES ($id, '$safeWord');";
      $exec = mysqli_query($this->db, $query);
    }
  }

  /**
   * add a list of required word
   */
  public function addAllRequiredWord($id, $wordArray) {
      foreach($wordArray as $word) {
        $this->addRequiredWord($id, $word);
      }
  }

  /**
   * edit a word
   * @param id - id of the competition
   * @param word - required word
   * @param newWord - new required word
   */
  public function editRequiredWord($id, $word, $newWord) {
    $queryCheck = "SELECT COUNT(*) FROM RequiredWord WHERE competition=$id AND word='$word';";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $result = mysqli_fetch_array($execCheck);

    if($result['COUNT(*)'] !== 0) {
      $query = "UPDATE RequiredWord SET word='$newWord' WHERE competition=$id AND word='$word';";
      $exec = mysqli_query($this->db, $query);
    }
  }

  /**
   * delete a required word
   * @param id - id of the competition
   * @param word - word to delete
   */
  public function deleteRequiredWord($id, $word) {
    $queryCheck = "SELECT COUNT(*) FROM RequiredWord WHERE competition=$id AND word='$word';";
    $execCheck = mysqli_query($this->db, $queryCheck);
    $result = mysqli_fetch_array($execCheck);

    if($result['COUNT(*)'] !== 0) {
      $query = "DELETE FROM RequiredWord WHERE competition=$id AND word='$word';";
      $exec = mysqli_query($this->db, $query);
    }
    
  }

  /**
   * get list of required word related to a competition
   * @param id - id of the competition
   * 
   */
  function getRequiredWords($id) {
    $query = "SELECT word FROM RequiredWord WHERE competition=$id";
    $exec = mysqli_query($this->db, $query);
    return $exec;
  }
}
