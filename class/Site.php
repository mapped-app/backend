<?php

class Site
{
    public $site_id;
    public $city_id;
    public $type;
    public $name;

    private $conn;
    private $db_table = "sites";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getSites()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function createSite()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET site_id = :site_id, city_id = :city_id, type = :type, name = :name";

        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":site_id", $this->site_id);
        $stmt->bindParam(":city_id", $this->city_id);
        $stmt->bindParam(":type", $this->type);
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getSiteById()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE site_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->site_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->site_id = $dataRow['site_id'];
        $this->city_id = $dataRow['city_id'];
        $this->type = $dataRow['type'];
        $this->name = $dataRow['name'];
    }

    // todo
    public function updateSite()
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
    function deleteSite()
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
