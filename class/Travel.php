<?php

class Travel
{
    public $travel_id;
    public $city_id;
    public $user_id;
    public $start_date;
    public $end_date;
    public $city_origen;
    public $transport;
    public $transport_cost;
    public $transport_time;
    public $travel_cost;
    public $travel_time;

    private $conn;
    private $db_table = "travels";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getTravels()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function createTravel()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " 
        SET 
        travel_id = :travel_id, 
        city_id = :city_id, 
        user_id = :user_id,
        start_date = :start_date,
        end_date = :end_date,
        city_origen = :city_origen,
        transport = :transport,
        transport_cost = :transport_cost,
        transport_time = :transport_time,
        travel_cost = :travel_cost,
        travel_time = :travel_time";

        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":travel_id", $this->travel_id);
        $stmt->bindParam(":city_id", $this->city_id);
        $stmt->bindParam(":user_id", $this->user_id);
        $stmt->bindParam(":start_date", $this->start_date);
        $stmt->bindParam(":end_date", $this->end_date);
        $stmt->bindParam(":city_origen", $this->city_origen);
        $stmt->bindParam(":transport", $this->transport);
        $stmt->bindParam(":transport_cost", $this->transport_cost);
        $stmt->bindParam(":transport_time", $this->transport_time);
        $stmt->bindParam(":travel_cost", $this->travel_cost);
        $stmt->bindParam(":travel_time", $this->travel_time);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getTravelById()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE travel_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->travel_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->travel_id = $dataRow['travel_id'];
        $this->city_id = $dataRow['city_id'];
        $this->user_id = $dataRow['user_id'];
        $this->start_date = $dataRow['start_date'];
        $this->end_date = $dataRow['end_date'];
        $this->city_origen = $dataRow['city_origen'];
        $this->transport = $dataRow['transport'];
        $this->transport_cost = $dataRow['transport_cost'];
        $this->transport_time = $dataRow['transport_time'];
        $this->travel_cost = $dataRow['travel_cost'];
        $this->travel_time = $dataRow['travel_time'];
    }

    public function getTravelByUserId()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE user_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->user_id);
        $stmt->execute();

        return $stmt;
    }

    // todo
    public function updateTravel()
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
    function deleteTravel()
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
