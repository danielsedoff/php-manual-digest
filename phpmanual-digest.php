<?php

/* This PHP program takes a one-file PHP manual for input
 * and outputs a digested version, that is, only the title
 * and the overview. The output file is 50 times smaller
 * and is useful either as a quick reference or as an index.
 */

 $filename = "php_manual_en.html";
 if(!file_exists($filename)) die("Need php_manual_en.html to process. No such file found.\n");
 $bigtext = file_get_contents($filename);
 

 $head = [];

 $head[0] = "<h1 class=\"refname\">";
 $foot[0] = "</h1>";

 $head[1] = "<span class=\"dc-title\">";
 $foot[1] = "</span>";

 $head[2] = "Description</h3>";
 $foot[2] = "</div>";

 $old_loc = 0;
 $new_text = "";
 $custom_text = "";

 while(true) {
 	print("$old_loc \n");
 	for($i = 0; $i < 3; ++$i) {	
		 $head_loc = strpos($bigtext, $head[$i], $old_loc);
		 if($head_loc < 1) goto ends;
		 $foot_loc = strpos($bigtext, $foot[$i], $head_loc);
		 if($foot_loc < 1) goto ends;
		 $sub_len = $foot_loc - $head_loc;

		 if ($i == 0) {
		 	$custom_text = "\n- - - -\n";
		 } else {
		 	$custom_text = "";
		 }

		 $added_text = strip_tags(substr($bigtext, $head_loc, $sub_len));
		 $added_text = str_replace("\n", " ", $added_text);
		 $added_text = str_replace("&lt;", "<", $added_text);
		 $added_text = str_replace("&gt;", ">", $added_text);
		 $added_text = str_replace("  ", " ", $added_text);
		 $added_text = str_replace("  ", " ", $added_text);
		 $added_text = str_replace("  ", " ", $added_text);
		 $added_text = str_replace("&raquo;&nbsp;", " ", $added_text);
		 $added_text = str_replace('&#039;', '\'', $added_text);
		 $added_text = str_replace("&quot;", "\"", $added_text);


		 $new_text .= "\n" . $custom_text . $added_text;
		 $old_loc = $foot_loc;
	}
 }

ends:
 $new_text = str_replace("\nDescription", "\n>", $new_text);
 file_put_contents("php-digest.txt", $new_text);
 echo "Success\n";
 die();

?>
