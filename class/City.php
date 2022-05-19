<?php

class City
{
    private $conn;
    private $db_table = "cities";

    public $city_id;
    public $province_id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCities()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function createCity()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET city_id = :city_id, province_id = :province_id, name = :name";

        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":city_id", $this->city_id);
        $stmt->bindParam(":province_id", $this->province_id);
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getCityById()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE city_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->city_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->city_id = $dataRow['city_id'];
        $this->province_id = $dataRow['province_id'];
        $this->name = $dataRow['name'];
    }

    public function updateCity()
    {
        $sqlQuery = "UPDATE " . $this->db_table . " SET name = :name WHERE city_id = :city_id";
        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteCity()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE city_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->city_id = htmlspecialchars(strip_tags($this->city_id));

        $stmt->bindParam(1, $this->city_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
