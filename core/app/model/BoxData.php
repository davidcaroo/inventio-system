<?php
class BoxData
{
    public static $tablename = "box";

    // Definir las propiedades
    public $id;
    public $name;
    public $lastname;
    public $email;
    public $image;
    public $password;
    public $created_at;

    // Constructor
    public function __construct()
    {
        $this->name = "";
        $this->lastname = "";
        $this->email = "";
        $this->image = "";
        $this->password = "";
        $this->created_at = date("Y-m-d H:i:s"); // Establecer la fecha y hora actual
    }
    /* 
    public function add() {
        // Asegúrate de que todos los campos necesarios estén presentes
        $sql = "INSERT INTO " . self::$tablename . " (name, lastname, email, image, password, created_at) ";
        $sql .= "VALUES ('$this->name', '$this->lastname', '$this->email', '$this->image', '$this->password', '$this->created_at')";
        return Executor::doit($sql);
    } */

    public function add()
    {
        $sql = "INSERT INTO " . self::$tablename . " (created_at) VALUES ('$this->created_at')";
        return Executor::doit($sql);
    }


    public static function delById($id)
    {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=$id";
        Executor::doit($sql);
    }

    public function del()
    {
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=$this->id";
        Executor::doit($sql);
    }

    public function update()
    {
        $sql = "UPDATE " . self::$tablename . " SET name=\"$this->name\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id)
    {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
        $query = Executor::doit($sql);
        $found = null;
        $data = new BoxData();
        while ($r = $query[0]->fetch_array()) {
            $data->id = $r['id'];
            $data->name = $r['name']; // Cargar el nombre
            $data->lastname = $r['lastname']; // Cargar el apellido
            $data->email = $r['email']; // Cargar el email
            $data->image = $r['image']; // Cargar la imagen
            $data->password = $r['password']; // Cargar la contraseña
            $data->created_at = $r['created_at']; // Cargar la fecha de creación
            $found = $data;
            break;
        }
        return $found;
    }

    public static function getAll()
    {
        $sql = "SELECT * FROM " . self::$tablename;
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while ($r = $query[0]->fetch_array()) {
            $array[$cnt] = new BoxData();
            $array[$cnt]->id = $r['id'];
          /*   $array[$cnt]->name = $r['name']; // Cargar el nombre
            $array[$cnt]->lastname = $r['lastname']; // Cargar el apellido
            $array[$cnt]->email = $r['email']; // Cargar el email
            $array[$cnt]->image = $r['image']; // Cargar la imagen
            $array[$cnt]->password = $r['password']; // Cargar la contraseña */
            $array[$cnt]->created_at = $r['created_at']; // Cargar la fecha de creación
            $cnt++;
        }
        return $array;
    }

    public static function getLike($q)
    {
        $sql = "SELECT * FROM " . self::$tablename . " WHERE name LIKE '%$q%'";
        $query = Executor::doit($sql);
        $array = array();
        $cnt = 0;
        while ($r = $query[0]->fetch_array()) {
            $array[$cnt] = new BoxData();
            $array[$cnt]->id = $r['id'];
            $array[$cnt]->name = $r['name']; // Cargar el nombre
            $array[$cnt]->lastname = $r['lastname']; // Cargar el apellido
            $array[$cnt]->email = $r['email']; // Cargar el email
            $array[$cnt]->image = $r['image']; // Cargar la imagen
            $array[$cnt]->password = $r['password']; // Cargar la contraseña
            $array[$cnt]->created_at = $r['created_at']; // Cargar la fecha de creación
            $cnt++;
        }
        return $array;
    }
}
