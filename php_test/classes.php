<?php
	
	/****OBJECT*******/
	class Object_Base{
		protected $id = 0;
		public function __construct(){}
		public function echo_id(){}
		public function change_id(int $new_id, bool $echo_new = false){
			$this->id = $new_id;
			if($echo_new)
				$this->echo_id();
			return;
		}
		public function get_area(){}
		public function get_values() : string{}
	}
	/*****************/
	
	/****TRIANGLE*****/
	class Triangle extends Object_Base{
		private $sides = [0, 0, 0];
		
		public function __construct(int $leg1, int $leg2, int $angle, int $id_num = 0){
			$this->id = $id_num;
			$this->sides[0] = $leg1;
			$this->sides[1] = $leg2;
			$this->sides[2] = $angle;//the 3rd variable is angle(grad) between legs
		}
		public function get_area(){
			return ($this->sides[0] * $this->sides[1] * sin(deg2rad($this->sides[2]))) / 2;
		}
		public function echo_id(){
			echo "Triangle ID: ".$this->id."\n";
			return;
		}
		public function get_values() : string{
			$sides_str = "0::";
			foreach($this->sides as $key=>$val){
				if($key == count($this->sides) - 1)
					$sides_str .= "$val";
				else
					$sides_str .= "$val, ";
			}
			return $this->id.": ".$sides_str."\n";
		}
	}
	/*****************/
	
	/****RECTANGLE****/
	class Rectangle extends Object_Base{
		private $sides = [0, 0];
		
		public function __construct(int $side_x, int $side_y, int $id_num = 0){
			$this->id = $id_num;
			$this->sides[0] = $side_x;
			$this->sides[1] = $side_y;
		}
		public function get_area(){
			return $this->sides[0] * $this->sides[1];
		}
		public function echo_id(){
			echo "Rectangle ID: ".$this->id."\n";
			return;
		}
		public function get_values() : string{
			$sides_str = "1::";
			foreach($this->sides as $key=>$val){
				if($key == count($this->sides) - 1)
					$sides_str .= "$val";
				else
					$sides_str .= "$val, ";
			}
			return $this->id.": ".$sides_str."\n";
		}
	}
	/*****************/
	
	/****CIRCLE******/
	class Circle extends Object_Base{
		private $rad = 0;
		const PI = 3.14;
		
		public function __construct(int $radius, int $id_num = 0){
			$this->id = $id_num;
			$this->rad = $radius;
		}
		public function get_area(){
			return Circle::PI * (($this->rad) ** 2);
		}
		public function echo_id(){
			echo "Circle ID: ".$this->id."\n";
			return;
		}
		public function get_values() : string{
			return $this->id.": 2::".$this->rad."\n";
		}
	}
	/*****************/

