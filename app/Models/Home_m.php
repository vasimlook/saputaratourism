<?php

namespace App\Models;

use CodeIgniter\Database\ConnectionInterface;
use CodeIgniter\Model;

class Home_m extends Model {
    protected $db;
    protected $session;    
    public function __construct() {
        $this->session = session();
        $this->db = db_connect();
        helper('functions');
    }
}
