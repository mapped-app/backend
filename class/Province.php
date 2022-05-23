<?php

class Province
{
    public $province_id;
    public $community_id;
    public $name;
    private $conn;
    private $db_table = "provinces";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getProvinces()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function createProvince()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET province_id = :province_id, community_id = :community_id, name = :name";

        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":province_id", $this->province_id);
        $stmt->bindParam(":community_id", $this->community_id);
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getProvinceById()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE province_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->province_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->province_id = $dataRow['province_id'];
        $this->community_id = $dataRow['community_id'];
        $this->name = $dataRow['name'];
    }

    public function getProvinceByName()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE name = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->name);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->province_id = $dataRow['province_id'];
        $this->community_id = $dataRow['community_id'];
        $this->name = $dataRow['name'];
    }

    public function updateProvince()
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

    function deleteProvince()
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
