<?php
// app/models/User.php

class User
{
  private $db;

  public function __construct()
  {
    $this->db = new Database();
  }

  public function getAllUsers()
  {
    $this->db->query('SELECT * FROM users');
    return $this->db->resultSet();
  }

  public function getUserById($id)
  {
    $this->db->query('SELECT * FROM users WHERE id = :id');
    $this->db->bind(':id', $id);
    return $this->db->single();
  }

  public function createUser($data)
  {
    $this->db->query('INSERT INTO users (name, email) VALUES (:name, :email)');
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);

    return $this->db->execute();
  }

  public function updateUser($data)
  {
    $this->db->query('UPDATE users SET name = :name, email = :email WHERE id = :id');
    $this->db->bind(':id', $data['id']);
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);

    return $this->db->execute();
  }

  public function deleteUser($id)
  {
    $this->db->query('DELETE FROM users WHERE id = :id');
    $this->db->bind(':id', $id);

    return $this->db->execute();
  }
}
