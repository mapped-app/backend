<?php

class BookedStay
{
    public $travel_id;
    public $stay_id;
    public $cost;
    public $rate;

    private $conn;
    private $db_table = "booked_stays";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getBookedStays()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function createBookedStay()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET travel_id = :travel_id, stay_id = :stay_id, cost = :cost, rate = :rate";

        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":travel_id", $this->travel_id);
        $stmt->bindParam(":stay_id", $this->stay_id);
        $stmt->bindParam(":cost", $this->cost);
        $stmt->bindParam(":rate", $this->rate);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getBookedStayByStayId()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE stay_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->stay_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->travel_id = $dataRow['travel_id'];
        $this->stay_id = $dataRow['stay_id'];
        $this->cost = $dataRow['cost'];
        $this->rate = $dataRow['rate'];
    }

    public function getBookedStayByTravelId()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE travel_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->travel_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->travel_id = $dataRow['travel_id'];
        $this->stay_id = $dataRow['stay_id'];
        $this->cost = $dataRow['cost'];
        $this->rate = $dataRow['rate'];
    }

    // todo
    public function updateBookedStay()
    {
        $sqlQuery = "UPDATE " . $this->db_table . " SET name = :name WHERE province_id = :province_id";
        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    // todo
    function deleteBookedStay()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE province_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->province_id = htmlspecialchars(strip_tags($this->province_id));

        $stmt->bindParam(1, $this->province_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
