<?php

class Community
{
    private $conn;
    private $db_table = "communities";

    public $community_id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getCommunities()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . "";
        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->execute();
        return $stmt;
    }

    public function createCommunity()
    {
        $sqlQuery = "INSERT INTO " . $this->db_table . " SET community_id = :community_id, name = :name";

        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":community_id", $this->community_id);
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function getCommunityById()
    {
        $sqlQuery = "SELECT * FROM " . $this->db_table . " WHERE community_id = ? LIMIT 0,1";

        $stmt = $this->conn->prepare($sqlQuery);
        $stmt->bindParam(1, $this->community_id);
        $stmt->execute();
        $dataRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->community_id = $dataRow['community_id'];
        $this->name = $dataRow['name'];
    }

    public function updateCommunity()
    {
        $sqlQuery = "UPDATE " . $this->db_table . " SET name = :name WHERE community_id = :community_id";
        $stmt = $this->conn->prepare($sqlQuery);

        // bind data
        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    function deleteCommunity()
    {
        $sqlQuery = "DELETE FROM " . $this->db_table . " WHERE community_id = ?";
        $stmt = $this->conn->prepare($sqlQuery);

        $this->community_id = htmlspecialchars(strip_tags($this->community_id));

        $stmt->bindParam(1, $this->community_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
