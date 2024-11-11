<?php
class ProductData {
    public static $tablename = "product";

    public function ProductData(){
        $this->name = "";
        $this->price_in = "";
        $this->price_out = "";
        $this->unit = "";
        $this->user_id = "";
        $this->presentation = "0";
        $this->created_at = "NOW()";
    }

    public function getCategory(){ 
        return CategoryData::getById($this->category_id);
    }

    public function add(){
        $sql = "INSERT INTO " . self::$tablename . " (barcode, name, description, price_in, price_out, user_id, presentation, unit, category_id, inventary_min, created_at) ";
        $sql .= "VALUES (\"$this->barcode\", \"$this->name\", \"$this->description\", \"$this->price_in\", \"$this->price_out\", $this->user_id, \"$this->presentation\", \"$this->unit\", $this->category_id, $this->inventary_min, NOW())";
        return Executor::doit($sql);
    }

    // Método para agregar productos en masa
	public static function addBulk($products) {
		$errors = 0;
	
		foreach ($products as $productData) {
			$product = new ProductData();
			$product->barcode = $productData['barcode'];
			$product->name = $productData['name'];
			$product->description = $productData['description'];
			$product->price_in = $productData['price_in'];
			$product->price_out = $productData['price_out'];
			$product->unit = $productData['unit'];
			$product->category_id = $productData['category_id'];
			$product->inventary_min = $productData['inventary_min'];
			$product->user_id = 1; // Cambiar según el usuario actual
			
			// Generar la consulta SQL para cada producto
			$sql = "INSERT INTO " . self::$tablename . " (barcode, name, description, price_in, price_out, user_id, unit, category_id, inventary_min, created_at) ";
			$sql .= "VALUES (\"$product->barcode\", \"$product->name\", \"$product->description\", \"$product->price_in\", \"$product->price_out\", $product->user_id, \"$product->unit\", $product->category_id, $product->inventary_min, NOW())";
			
			// Mostrar la consulta SQL para depuración
			echo "<pre>$sql</pre>";
			
			// Ejecutar la consulta e incrementar el contador de errores si falla
			$result = Executor::doit($sql);
			if (!$result) {
				$errors++;
			}
		}
	
		// Retornar el número de errores si hubo alguno, o 0 si todo se insertó correctamente
		return $errors;
	}
	
	

    public function add_with_image(){
        $sql = "INSERT INTO " . self::$tablename . " (barcode, image, name, description, price_in, price_out, user_id, presentation, unit, category_id, inventary_min) ";
        $sql .= "VALUES (\"$this->barcode\", \"$this->image\", \"$this->name\", \"$this->description\", \"$this->price_in\", \"$this->price_out\", $this->user_id, \"$this->presentation\", \"$this->unit\", $this->category_id, $this->inventary_min)";
        return Executor::doit($sql);
    }

    public static function delById($id){
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=$id";
        Executor::doit($sql);
    }

    public function del(){
        $sql = "DELETE FROM " . self::$tablename . " WHERE id=$this->id";
        Executor::doit($sql);
    }

    public function update(){
        $sql = "UPDATE " . self::$tablename . " SET barcode=\"$this->barcode\", name=\"$this->name\", price_in=\"$this->price_in\", price_out=\"$this->price_out\", unit=\"$this->unit\", presentation=\"$this->presentation\", category_id=$this->category_id, inventary_min=\"$this->inventary_min\", description=\"$this->description\", is_active=\"$this->is_active\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public function del_category(){
        $sql = "UPDATE " . self::$tablename . " SET category_id=NULL WHERE id=$this->id";
        Executor::doit($sql);
    }

    public function update_image(){
        $sql = "UPDATE " . self::$tablename . " SET image=\"$this->image\" WHERE id=$this->id";
        Executor::doit($sql);
    }

    public static function getById($id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id=$id";
        $query = Executor::doit($sql);
        return Model::one($query[0], new ProductData());
    }

    public static function getAll(){
        $sql = "SELECT * FROM " . self::$tablename;
        $query = Executor::doit($sql);
        return Model::many($query[0], new ProductData());
    }

    public static function getAllByPage($start_from, $limit){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE id >= $start_from LIMIT $limit";
        $query = Executor::doit($sql);
        return Model::many($query[0], new ProductData());
    }

    public static function getLike($p){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE barcode LIKE '%$p%' OR name LIKE '%$p%' OR id LIKE '%$p%'";
        $query = Executor::doit($sql);
        return Model::many($query[0], new ProductData());
    }

    public static function getAllByUserId($user_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE user_id=$user_id ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new ProductData());
    }

    public static function getAllByCategoryId($category_id){
        $sql = "SELECT * FROM " . self::$tablename . " WHERE category_id=$category_id ORDER BY created_at DESC";
        $query = Executor::doit($sql);
        return Model::many($query[0], new ProductData());
    }

	public static function getAllActive(){
		$sql = "SELECT * FROM " . self::$tablename . " WHERE is_active=1";
		$query = Executor::doit($sql);
		return Model::many($query[0], new ProductData());
	}

	
}
