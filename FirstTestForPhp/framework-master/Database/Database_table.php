<?php

namespace framework\Database;

// table类，多了一个private参数table, 调用地时候不需要在填写类名了。
class Database_table {
  private static $instance = '';

  public $db = '';
  public $table = '';

 public static function instance ($table = '', $db_name = '', $db_host = '', $db_username = '', $db_password = ''){
    $instance = self::$instance;
    if (empty($instance) || $instance->db->db_host != $db_host || $instance->db->db_username != $db_username || $instance->db->db_password != $db_password || $instance->db->db_name != $db_name || $instance->table != $table) {
      self::$instance = new Database_table($table, $db_name, $db_host, $db_username, $db_password);
    }
    return self::$instance;
  }

  protected function __construct($table = '', $db_name = '', $db_host = '', $db_username = '', $db_password = ''){
    $this->table = $table;
    $this->db = Database::instance($db_name, $db_host, $db_username, $db_password);
  }

  public function set_table($table) {
    $this->table = $table;
  }

  // get_all
  public function get_all($where = '', $addons = '') {
    return $this->db->get_all($this->table, $where, $addons);
  }

  // get_one
  public function get_one($where = '', $addons = '') {
    return $this->db->get_one($this->table, $where, $addons);
  }

  // insert
  public function insert($data) {
    return $this->db->insert($this->table, $data);
  }

  // update
  public function update($data, $where) {
    return $this->db->update($this->table, $data, $where);
  }

  // delete
  public function delete($where) {
    return $this->db->delete($this->table, $where);
  }
  

  // begintransaction
  public function begin_transaction () {
    return $this->db->begin_transaction();
  }

  // commit 
  public function commit () {
    return $this->db->commit();
  }

  // rollback
  public function rollback() {
    return $this->db->rollback();
  }

  // lastInsertId 
  public function last_insert_id () {
    return $this->db->last_insert_id();
  }

  // exec
  public function exec($query) {
    Logging::d("EXEC", $query);
    return $this->db->exec($query);
  }



}





