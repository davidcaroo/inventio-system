<?php
class SellData
{
	public static $tablename = "sell";
	
	public function __construct()
	{
		$this->created_at = null;
        $this->note = ""; // Inicializa note como una cadena vacía
        $this->total = 0; // Inicializa total en 0 
        $this->discount = 0; // Inicializa discount en 0 
        $this->user_id = null; // Inicializa user_id como null
	}

	public function getPerson()
	{
		return PersonData::getById($this->person_id);
	}

	public function getUser()
	{
		return UserData::getById($this->user_id);
	}

	// Método para agregar una venta con el campo note
	public function add()
	{
		$sql = "INSERT INTO " . self::$tablename . " (total, discount, user_id, note, created_at) ";
		$sql .= "VALUES ($this->total, $this->discount, $this->user_id, '$this->note', NOW())";
		return Executor::doit($sql);
	}

	// Método para agregar una venta con cliente y el campo note
	public function add_with_client()
	{
		$sql = "INSERT INTO " . self::$tablename . " (total, discount, person_id, user_id, note, created_at) ";
		$sql .= "VALUES ($this->total, $this->discount, $this->person_id, $this->user_id, '$this->note', NOW())";
		return Executor::doit($sql);
	}
	public static function getSells()
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE operation_type_id = 2 ORDER BY created_at DESC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}
	
	public static function delById($id)
	{
		$sql = "DELETE FROM " . self::$tablename . " WHERE id = $id";
		Executor::doit($sql);
	}

	public function del()
	{
		$sql = "DELETE FROM " . self::$tablename . " WHERE id = $this->id";
		Executor::doit($sql);
	}

	// Otros métodos...

	public static function getById($id)
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE id = $id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new SellData());
	}

	/* method SellData::getByPersonId()*/
	public static function getByPersonId($id)
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE person_id = $id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	/* agregar el metodo getSellsUnBoxed() */
	public static function getSellsUnBoxed()
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE operation_type_id = 2 AND box_id IS NULL ORDER BY created_at DESC";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	/* agregar el metodo getByBoxId() */
	public static function getByBoxId($id)
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE box_id = $id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	/* agregar method SellData::update_box()  */
	public function update_box()
	{
		$sql = "update " . self::$tablename . " set box_id=$this->box_id where id=$this->id";
		Executor::doit($sql);
	}
	/* agregar el metodo SellData::getAllByDateOp() */
	public static function getAllByDateOp($start, $end, $op)
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE created_at >= \"$start\" AND created_at <= \"$end\" AND operation_type_id = $op";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}
	
	/* agregar el metodo SellData::getAllByDateBCOp() */
	public static function getAllByDateBCOp($client_id, $start, $end, $op)
	{
		$sql = "SELECT * FROM " . self::$tablename . " WHERE person_id = $client_id AND created_at >= \"$start\" AND created_at <= \"$end\" AND operation_type_id = $op";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

		// Método para agregar un reabastecimiento sin cliente
		public function add_re()
		{
			$sql = "INSERT INTO " . self::$tablename . " (total, discount, user_id, note, operation_type_id, created_at) ";
			$sql .= "VALUES ($this->total, $this->discount, $this->user_id, '$this->note', 1, NOW())";
			return Executor::doit($sql);
		}
	
		// Método para agregar un reabastecimiento con cliente
		public function add_re_with_client()
		{
			$sql = "INSERT INTO " . self::$tablename . " (total, discount, person_id, user_id, note, operation_type_id, created_at) ";
			$sql .= "VALUES ($this->total, $this->discount, $this->person_id, $this->user_id, '$this->note', 1, NOW())";
			return Executor::doit($sql);
		}

		/* method SellData::getRes()  */
		public static function getRes()
		{
			$sql = "SELECT * FROM " . self::$tablename . " WHERE operation_type_id = 1 ORDER BY created_at DESC";
			$query = Executor::doit($sql);
			return Model::many($query[0], new SellData());
		}
}

