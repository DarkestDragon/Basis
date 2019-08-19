<?php

	require_once "./classes.php";

	/****RAND_FIGURE****/
	//returns new random figure, or NULL in case of error
	function rand_figure(){
		static $id_num = -1;
		$arr = ["Triangle", "Rectangle", "Circle"];
		$index = rand(0, count($arr) - 1);
		$class_name = $arr[$index];
		$id_num++;
		switch($class_name){
			case "Triangle":
				return new Triangle(rand(), rand(), rand(0, 179), $id_num);
			case "Rectangle":
				return new Rectangle(rand(), rand(), $id_num);
			case "Circle":
				return new Circle(rand(), $id_num);
			default:
				echo "Unknown class name! Only Triangle, Rectangle and Circle!\n";
				return NULL;
		}
	}
	/*****************/
	
	/****SAVE_FILE****/
	//saves all figures in text file
	function save_file(string $filename, array $fig_array) : bool{
		$arr_size = count($fig_array);
		$fhandl = fopen($filename, 'w');
		if(!$fhandl){
			echo "File can't be opened!\n";
			return false;
		}
		for($i = 0; $i < $arr_size; $i++){
			if(!fwrite($fhandl, $fig_array[$i]->get_values())){
				echo "Error occured while saving the data.\n";
				return false;
			}
			if($i == $arr_size - 1)
				fwrite($fhandl, "\\");//defines the end of data
		}
		fclose($fhandl);
		return true;
	}
	/*****************/
	
	/****PARSEVAL*****/
	//parses value in string, may return "int" or "float" type value
	function parseval(array $str, int $offset){
		$frac_part = 0;//fractional part
		$int_part = 0;//integer part
		$float_flag = false;//if true then parsed value, have a "float" type
		$rate = 1;
		$neg_flag = false;//if integer part of negative value == 0, this var will be true
		$was_minus = false;//created to prevent extra value's sign flips
		
		for($i = $offset; $i >= 0; $i--){
			if(is_numeric($str[$i])){
				(!$float_flag) ? $frac_part += (int)$str[$i] * $rate : $int_part += (int)$str[$i] * $rate;
			}
			else if($str[$i] === '.'){
				$float_flag = true;
				$rate = 1;
			}
			else if($str[$i] === '-' && !$was_minus){
				(!$float_flag) ? $frac_part = -$frac_part : $int_part = -$int_part;
				if(!$float_flag)
					return $frac_part;
				if($int_part == 0)
					$neg_flag = true;
				$was_minus = true;
			}
			else{//if not a number or dot, or minus sign - return value
				if(!$float_flag)//if parsed value is integer
					return $frac_part;
				else{
					while(($frac_part /= 10) >= 1)
						;
					if($int_part < 0 || $neg_flag)
						$frac_part = -$frac_part;
					return $int_part + $frac_part;
				}
			}
			$rate *= 10;
		}
		return 0;//if error occurs or line ends accidentally
	}
	/*****************/
	
	/****PARSE********/
	//parses file's content and returns a array of figures
	function parse(array $content): array{
		$id_item = 0;
		$sides_item = [];
		$rad_item = 0;//radius
		$arr = [];//array with loaded objects
		$name_item = NULL;//stores class name defined by taken value, 0-Triangle, 1-Rectangle, 2-Circle
		
		for($i = 0; $i < count($content); $i++){
			switch($content[$i]){
				case "\n"://recreate object
					($name_item !== 2) ? 
						$sides_item[] = parseval($content, $i - 1) : 
						$rad_item = parseval($content, $i - 1);//taking last value in line
					switch($name_item){
						case 0:
							$arr[] = new Triangle($sides_item[0], $sides_item[1], $sides_item[2], $id_item);
							break;
						case 1:
							$arr[] = new Rectangle($sides_item[0], $sides_item[1], $id_item);
							break;
						case 2:
							$arr[] = new Circle($rad_item, $id_item);
							break;
					}
					
					$name_item = NULL;
					$id_item = $rad_item = 0;
					unset($sides_item);
					$sides_item = [];
					break;
				
				case "\\"://end of data reached
					return $arr;
				
				case ":":
					if($content[$i + 1] == ':'){//if true, take figure name
						switch($content[$i - 1]){
							case '0':
								$name_item = 0;//Triangle
								break;
							case '1':
								$name_item = 1;//Rectangle
								break;
							case '2':
								$name_item = 2;//Circle
								break;
						}
						$i++;
					}
					else if($content[$i + 1] == ' ')//else take object's ID
						$id_item = parseval($content, $i - 1);
						$i++;
					break;
				
				case ","://take value
					$sides_item[] = parseval($content, $i - 1);
					break;
			}
		}
	}
	/*****************/
	
	/****LOAD_FILE****/
	//restores figures from text file, returns a array of figures, or empty string in case of error
	function load_file(string $filename) : array{
		$str = file_get_contents($filename);
		if(!$str){
			echo "Error occured while opening or reading the file!\n";
			return [];
		}
		return parse(str_split($str));
	}
	/*****************/

