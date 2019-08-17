<?php

	require_once "./classes.php";

	/****RAND_FIGURE****/
	//returns new random figure, or NULL in case of error
	function rand_figure(){
		static $id_num = -1;
		$arr = ["Triangle", "Rectangle", "Circle"];
		$index = rand(0, count($arr) - 1);
		$class_name = $arr[$index];
		echo "Creating $class_name\n";
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
				fwrite($fhandl, "\a");//defines the end of data
		}
		fclose($fhandl);
		return true;
	}
	/*****************/
	
	/****PARSEVAL*****/
	//parses value in string, may return "int" or "float" type value
	function parseval(string $str, int $offset){
		
	}
	/*****************/
	
	/****PARSE********/
	//parses file's content and returns a array of figures
	function parse(string $content): array{
		$id_item = 0;
		$sides_item = [];
		$rad_item = 0;//radius
		$arr = [];//array with loaded objects
		$name_item = NULL;//stores class name defined by taken value, 0-Triangle, 1-Rectangle, 2-Circle
		for($i = 0; $i < count($content); $i++){
			switch($content[$i]){
				case '\n'://recreate object
				
					//taking last value in line
					if($name_item !== 2)
						$sides_item[] = parseval($content, $i - 1);
					else
						$rad_item = parseval($content, $i - 1);
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
				
				case '\a'://end of data reached
					return $arr;
				
				case ':':
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
					break;
				
				case ','://take value
					$sides_item[] = parseval($content, $i - 1);
					break;
			}
		}
	}
	/*****************/
	
	/****LOAD_FILE****/
	//restores figures from text file, returns a array of figures, or empty string in case of error
	function load_file(string $filename) : string{//array{
		$str = file_get_contents($filename);
		if(!$str){
			echo "Error occured while opening or reading the file!\n";
			//return [];
			return "";
		}
		//return parse($str);
		return $str;
	}
	/*****************/

