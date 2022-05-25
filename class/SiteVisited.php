<?php

class SiteVisited
{
    public $travel_id;
    public $site_id;
    public $cost;
    public $rate;

    private $conn;
    private $db_table = "sites_visited";

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getSitesVisited()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function createSiteVisited()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET travel_id = :travel_id, site_id = :site_id, cost = :cost, rate = :rate";

        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":travel_id", $this->travel_id);
        $stmt->bindParam(":site_id", $this->site_id);
        $stmt->bindParam(":cost", $this->cost);
        $stmt->bindParam(":rate", $this->rate);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getSiteVisitedBySiteId()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE site_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->site_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->travel_id = $dataRow['travel_id'];
        $this->site_id = $dataRow['site_id'];
        $this->cost = $dataRow['cost'];
        $this->rate = $dataRow['rate'];
    }

    public function getSiteVisitedByTravelId()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE travel_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->travel_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->travel_id = $dataRow['travel_id'];
        $this->site_id = $dataRow['site_id'];
        $this->cost = $dataRow['cost'];
        $this->rate = $dataRow['rate'];
    }

    // todo
    public function updateSiteVisited()
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
    function deleteSiteVisited()
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
