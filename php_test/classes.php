<?php
	/****TRIANGLE*****/
	class Triangle{
		protected $id = 0;
		private $sides = [0, 0, 0];
		
		public function __construct(int $leg1, int $leg2, int $angle, int $id_num = 0){
			$this->id = $id_num;
			$this->sides[0] = $leg1;
			$this->sides[1] = $leg2;
			$this->sides[2] = sin(deg2rad($angle));//the 3rd variable is sin(angle(rads)) between legs
		}
		public function get_area(){
			return ($this->sides[0] * $this->sides[1] * $this->sides[2]) / 2;
		}
		public function echo_id(){
			echo "Triangle ID: ".$this->id."\n";
			return;
		}
		public function change_id(int $new_id, bool $echo_new = false){
			$this->id = $new_id;
			if($echo_new)
				$this->echo_id();
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
	class Rectangle extends Triangle{
		//private $id = 0;
		private $sides = [0, 0];
		
		public function __construct(int $side_x, int $side_y, int $id_num = 0){
			$this->id = $id_num;
			$this->side[0] = $side_x;
			$this->side[1] = $side_y;
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
	class Circle{
		private $id = 0;
		private $rad = 0;
		private const PI = 3.14;
		
		public function __construct(int $radius, int $id_num = 0){
			$this->id = $id_num;
			$this->rad = $radius;
		}
		public function get_area(){
			return PI * (($this->rad) ** 2);
		}
		public function echo_id(){
			echo "Circle ID: ".$this->id."\n";
			return;
		}
		public function change_id(int $new_id, bool $echo_new = false){
			$this->id = $new_id;
			if($echo_new)
				$this->echo_id();
			return;
		}
		public function get_values() : string{
			return $this->id.": 2::".$this->rad."\n";
		}
	}
	/*****************/

