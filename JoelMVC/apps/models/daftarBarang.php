<?php

include __DIR__ . '/../Model.php';

class daftarBarang extends Model{
    private $daftar = [];
    protected $db = null;

    public function __construct() {
        $this->db = new DB();
        $this->db->connect('mysql','localhost','root','santa123','mvcapp');
    }

    public function getDataAll() {
        $stmt = "select * from daftarbarang";
        $query = $this->db->query($stmt);
        $data = [];
        while ($result = $this->db->fetch_array($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getDataById($id) {
        $stmt = "select * from daftarbarang where id = $id";
        $query = $this->db->query($stmt);
        $data = [];
        $data = $this->db->fetch_array($query);
        return $data;
    }

    public function tambahBarang($params) {
        $stmt = "insert into daftarbarang (nama, qty) values (:nama, :qty)";
        $query = $this->db->query($stmt, $params);
        if ($this->db->last_id()>0) {
            return true;
        }
        else return false;
    }

    public function updateBarang($params) {
        $stmt = "update daftarbarang set nama = :nama, qty = :qty where id = :id";
        $query = $this->db->query($stmt, $params);
        if ($query->rowCount()>0) {
            return true;
        }
        else {
            return false;
        }
    }

    public function hapusBarang($id) {
        $stm = "delete from daftarbarang where id = $id";
        $query = $this->db->query($stm);
        if ($query->rowCount()>0) {
            return true;
        }
        else {
            return false;
        }
    }
    
   
}