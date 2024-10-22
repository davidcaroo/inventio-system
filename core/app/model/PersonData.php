<?php
class PersonData {
    public static $tablename = "person";

    public function __construct() {
        $this->name = "";
        $this->lastname = "";
        $this->email1 = "";  // Cambié de email a email1 para que coincida con la base de datos
        $this->address1 = ""; // Agregué esta propiedad
        $this->phone1 = "";   // Agregué esta propiedad
        $this->kind = 1;      // Asumí que el valor por defecto es cliente
        $this->created_at = date('Y-m-d H:i:s'); // Establezco la fecha de creación
    }

    public function add_client() {
        $sql = "INSERT INTO " . self::$tablename . " (name, lastname, address1, email1, phone1, kind, created_at) VALUES (\"$this->name\", \"$this->lastname\", \"$this->address1\", \"$this->email1\", \"$this->phone1\", 1, NOW())";
        Executor::doit($sql);
    }

    public function add_provider() {
        $sql = "INSERT INTO " . self::$tablename . " (name, lastname, address1, email1, phone1, kind, created_at) VALUES (\"$this->name\", \"$this->lastname\", \"$this->address1\", \"$this->email1\", \"$this->phone1\", 2, NOW())";
        Executor::doit($sql);
    }

    public static function delById($id) {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = $id";
        Executor::doit($sql);
    }

    public function del() {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id = $this->id";
        Executor::doit($sql);
    }

    public function update() {
        $sql = "UPDATE " . self::$tablename . " SET name=\"$this->name\", email1=\"$this->email1\", address1=\"$this->address1\", lastname=\"$this->lastname\", phone1=\"$this->phone1\" WHERE id = $this->id";
        Executor::doit($sql);
    }
    public function update_client() {
        $sql = "UPDATE " . self::$tablename . " SET name=\"$this->name\", email1=\"$this->email1\", address1=\"$this->address1\", lastname=\"$this->lastname\", phone1=\"$this->phone1\" WHERE id = $this->id";
        Executor::doit($sql);
    }

    public function update_passwd() {
        $sql = "UPDATE " . self::$tablename . " SET password=\"$this->password\" WHERE id = $this->id";
        Executor::doit($sql);
    }

    public static function getById($id) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id = $id";
        $query = Executor::doit($sql);
        $found = null;
        $data = new PersonData();
        while ($r = $query[0]->fetch_array()) {
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->lastname = $r['lastname'];
            $data->address1 = $r['address1'];
            $data->phone1 = $r['phone1'];
            $data->email1 = $r['email1'];
            $data->created_at = $r['created_at'];
            $found = $data;
            break;
        }
        return $found;
    }

    public static function getAll() {
        $sql = "SELECT * FROM " . self::$tablename;
        $query = Executor::doit($sql);
        $array = array();
        while ($r = $query[0]->fetch_array()) {
            $data = new PersonData();
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->lastname = $r['lastname'];
            $data->email1 = $r['email1'];
            $data->phone1 = $r['phone1'];
            $data->address1 = $r['address1'];
            $data->created_at = $r['created_at'];
            $array[] = $data;
        }
        return $array;
    }

    public static function getClients() {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE kind = 1 ORDER BY name, lastname";
        $query = Executor::doit($sql);
        $array = array();
        while ($r = $query[0]->fetch_array()) {
            $data = new PersonData();
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->lastname = $r['lastname'];
            $data->email1 = $r['email1'];
            $data->phone1 = $r['phone1'];
            $data->address1 = $r['address1'];
            $data->created_at = $r['created_at'];
            $array[] = $data;
        }
        return $array;
    }

    public static function getProviders() {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE kind = 2 ORDER BY name, lastname";
        $query = Executor::doit($sql);
        $array = array();
        while ($r = $query[0]->fetch_array()) {
            $data = new PersonData();
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->lastname = $r['lastname'];
            $data->email1 = $r['email1'];
            $data->phone1 = $r['phone1'];
            $data->address1 = $r['address1'];
            $data->created_at = $r['created_at'];
            $array[] = $data;
        }
        return $array;
    }

    public static function getLike($q) {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE name LIKE '%$q%'";
        $query = Executor::doit($sql);
        $array = array();
        while ($r = $query[0]->fetch_array()) {
            $data = new PersonData();
            $data->id = $r['id'];
            $data->name = $r['name'];
            $data->created_at = $r['created_at'];
            $array[] = $data;
        }
        return $array;
    }
}
?>
