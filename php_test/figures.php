<?php
	
	require_once "./classes.php";
	require_once "./figures_funcs.php";
	
	echo "Тестовое задание 3\n";
	function task3(int $array_size){
		for($i = 0; $i < $array_size; $i++){
			$fig_array[] = rand_figure();
			$area_array[] = $fig_array[$i]->get_area();
		}
			save_file("./figures.txt", $fig_array);
			unset($fig_array);
			$fig_array = load_file("./figures.txt");
			print_r($fig_array);
	}
	
	task3(10);

