<?php

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


  // temukan user berdasarkan email
  public function findByEmail($email)
  {
    $this->db->query('SELECT * FROM users WHERE email = :email LIMIT 1');
    $this->db->bind(':email', $email);
    return $this->db->single();
  }

  // temukan user by provider + provider_id
  public function findByProvider($provider, $providerId)
  {
    $this->db->query('SELECT * FROM users WHERE provider = :provider AND provider_id = :pid LIMIT 1');
    $this->db->bind(':provider', $provider);
    $this->db->bind(':pid', $providerId);
    return $this->db->single();
  }

  // create user dengan password hash
  public function createLocalUser($data)
  {
    $this->db->query('INSERT INTO users (name, email, password_hash, created_at, updated_at) VALUES (:name, :email, :ph, NOW(), NOW())');
    $this->db->bind(':name', $data['name']);
    $this->db->bind(':email', $data['email']);
    $this->db->bind(':ph', $data['password_hash']);
    return $this->db->execute();
  }

  // create atau update user dari provider SSO
  public function createOrUpdateFromProvider($provider, $providerId, $name, $email)
  {
    // cek ada tidak
    $existing = $this->findByProvider($provider, $providerId);
    if ($existing) {
      // update nama / email bila perlu
      $this->db->query('UPDATE users SET name=:name, email=:email, updated_at=NOW() WHERE id=:id');
      $this->db->bind(':name', $name);
      $this->db->bind(':email', $email);
      $this->db->bind(':id', $existing->id);
      $this->db->execute();
      return $this->findByProvider($provider, $providerId);
    }

    // jika tidak ada, tapi ada user dengan email sama -> hubungkan
    $byEmail = $this->findByEmail($email);
    if ($byEmail) {
      // hubungkan provider ke user existing
      $this->db->query('UPDATE users SET provider=:provider, provider_id=:pid, updated_at=NOW() WHERE id=:id');
      $this->db->bind(':provider', $provider);
      $this->db->bind(':pid', $providerId);
      $this->db->bind(':id', $byEmail->id);
      $this->db->execute();
      return $this->findByEmail($email);
    }

    // buat baru
    $this->db->query('INSERT INTO users (name, email, provider, provider_id, created_at, updated_at) VALUES (:name, :email, :provider, :pid, NOW(), NOW())');
    $this->db->bind(':name', $name);
    $this->db->bind(':email', $email);
    $this->db->bind(':provider', $provider);
    $this->db->bind(':pid', $providerId);
    $this->db->execute();

    // ambil record baru
    $this->db->query('SELECT * FROM users WHERE provider = :provider AND provider_id = :pid LIMIT 1');
    $this->db->bind(':provider', $provider);
    $this->db->bind(':pid', $providerId);
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
