<?php
// includes/Request.php
// Request model with CRUD operations

// Make sure Database class is loaded
require_once __DIR__ . '/Database.php';

class Request {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    public function getAll($filters = []) {
        $sql = "SELECT * FROM requests WHERE 1=1";
        $params = [];
        
        if (!empty($filters['status'])) {
            $sql .= " AND status = :status";
            $params[':status'] = $filters['status'];
        }
        
        if (!empty($filters['priority'])) {
            $sql .= " AND priority = :priority";
            $params[':priority'] = $filters['priority'];
        }
        
        if (!empty($filters['search'])) {
            // Fix: Use named placeholders correctly - one placeholder per parameter
            $sql .= " AND (fullname LIKE :search_name OR email LIKE :search_email)";
            $searchTerm = '%' . $filters['search'] . '%';
            $params[':search_name'] = $searchTerm;
            $params[':search_email'] = $searchTerm;
        }
        
        $sql .= " ORDER BY 
            CASE priority 
                WHEN 'high' THEN 1 
                WHEN 'normal' THEN 2 
                WHEN 'low' THEN 3 
            END,
            created_at DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM requests WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch();
    }
    
    public function create($data) {
        $sql = "INSERT INTO requests (fullname, email, subject, description, priority) 
                VALUES (:fullname, :email, :subject, :description, :priority)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':fullname' => $data['fullname'],
            ':email' => $data['email'],
            ':subject' => $data['subject'],
            ':description' => $data['description'],
            ':priority' => $data['priority']
        ]);
        
        return $this->db->lastInsertId();
    }
    
    public function updateStatus($id, $status) {
        $stmt = $this->db->prepare("UPDATE requests SET status = :status WHERE id = :id");
        return $stmt->execute([
            ':id' => $id,
            ':status' => $status
        ]);
    }
    
    public function update($id, $data) {
        $sql = "UPDATE requests SET 
                fullname = :fullname,
                email = :email,
                subject = :subject,
                description = :description,
                priority = :priority
                WHERE id = :id";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute([
            ':id' => $id,
            ':fullname' => $data['fullname'],
            ':email' => $data['email'],
            ':subject' => $data['subject'],
            ':description' => $data['description'],
            ':priority' => $data['priority']
        ]);
        
        return $stmt->rowCount() > 0;
    }
}