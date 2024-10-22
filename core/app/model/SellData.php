<?php
class SellData
{
	public static $tablename = "sell";

	// Constructor sin "NOW()" directo
	public function SellData()
	{
		$this->created_at = null; // Inicialmente nulo, se establecerá en la consulta SQL
	}

	public function getPerson()
	{
		return PersonData::getById($this->person_id);
	}
	public function getUser()
	{
		return UserData::getById($this->user_id);
	}

	public function add()
	{
		$sql = "insert into " . self::$tablename . " (total, discount, user_id, created_at) ";
		$sql .= "values ($this->total, $this->discount, $this->user_id, NOW())"; // Aquí usamos NOW() directamente en la consulta SQL
		return Executor::doit($sql);
	}

	public function add_re()
	{
		$sql = "insert into " . self::$tablename . " (user_id, operation_type_id, created_at) ";
		$sql .= "values ($this->user_id, 1, NOW())"; // También aquí
		return Executor::doit($sql);
	}

	public function add_with_client()
	{
		$sql = "insert into " . self::$tablename . " (total, discount, person_id, user_id, created_at) ";
		$sql .= "values ($this->total, $this->discount, $this->person_id, $this->user_id, NOW())";
		return Executor::doit($sql);
	}

	public function add_re_with_client()
	{
		$sql = "insert into " . self::$tablename . " (person_id, operation_type_id, user_id, created_at) ";
		$sql .= "values ($this->person_id, 1, $this->user_id, NOW())";
		return Executor::doit($sql);
	}

	public static function delById($id)
	{
		$sql = "delete from " . self::$tablename . " where id=$id";
		Executor::doit($sql);
	}

	public function del()
	{
		$sql = "delete from " . self::$tablename . " where id=$this->id";
		Executor::doit($sql);
	}

	public function update_box()
	{
		$sql = "update " . self::$tablename . " set box_id=$this->box_id where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id)
	{
		$sql = "select * from " . self::$tablename . " where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0], new SellData());
	}

	public static function getSells()
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=2 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	public static function getSellsUnBoxed()
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=2 and box_id is NULL order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	public static function getByBoxId($id)
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=2 and box_id=$id order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	public static function getRes()
	{
		$sql = "select * from " . self::$tablename . " where operation_type_id=1 order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	public static function getAllByPage($start_from, $limit)
	{
		$sql = "select * from " . self::$tablename . " where id<=$start_from limit $limit";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	public static function getAllByDateOp($start, $end, $op)
	{
		$sql = "select * from " . self::$tablename . " where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	public static function getAllByDateBCOp($person_id, $start, $end, $op)
	{
		$sql = "select * from " . self::$tablename . " where date(created_at) >= \"$start\" and date(created_at) <= \"$end\" and person_id=$person_id  and operation_type_id=$op order by created_at desc";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}

	public static function getByPersonId($person_id) {
		$sql = "SELECT * FROM sell WHERE person_id = $person_id";
		$query = Executor::doit($sql);
		return Model::many($query[0], new SellData());
	}
	
}

