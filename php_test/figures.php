<?php
	
	require_once "./classes.php";
	require_once "./figures_funcs.php";
	
	function sort_figs(array $figs, array $areas) : array{
		$new_array = [];
		$max_index = count($figs);
		for($i = 0; $i < $max_index; $i++){
			for($i2 = 0; $i2 < $max_index; $i2++){
				if($figs[$i2]->get_area() == $areas[$i]){
					$new_array[$i] = $figs[$i2];
					break;
				}
			}
		}
		return $new_array;
	}
	
	echo "Тестовое задание 3\n";

	for($i = 0; $i < 10; $i++){
		$fig_array[] = rand_figure(0, 128);
		$area_array[] = $fig_array[$i]->get_area();
	}
	save_file("./figures.txt", $fig_array);
	unset($fig_array);
	$fig_array = load_file("./figures.txt");
	rsort($area_array);
	print_r($fig_array);
	$new_fig_array = sort_figs($fig_array, $area_array);
	print_r($new_fig_array);

