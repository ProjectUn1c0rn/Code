<?php
namespace Un1c0rn\Web;
class TemplateEngine extends \Blitz {
function time2ago($timeline) {
   $timeline = time()-$timeline;
    $periods = array('day' => 86400, 'hour' => 3600, 'minute' => 60);
    $ret = '';
    foreach($periods AS $name => $seconds){
        $num = floor($timeline / $seconds);
        $timeline -= ($num * $seconds);
        if($num >0)
	  $ret .= $num.' '.$name.(($num > 1) ? 's' : '').' ';
    }

    return trim($ret);
}
	function cutEscapeString($string,$size) {
		return htmlentities(substr($string,0,$size).'...');
	}
	//function to return the pagination string
	//http://www.strangerstudios.com/sandbox/pagination/diggstyle_function.txt
	function getPaginationString($page = 1, $totalitems, $limit = 15, $adjacents = 1, $targetpage = "/", $pagestring = "?page=")
	{		
	//defaults
	if(!$adjacents) $adjacents = 1;
	if(!$limit) $limit = 15;
	if(!$page) $page = 1;
	if(!$targetpage) $targetpage = "/";
	
	//other vars
	$prev = $page - 1;									//previous page is page - 1
	$next = $page + 1;									//next page is page + 1
	$lastpage = ceil($totalitems / $limit);				//lastpage is = total items / items per page, rounded up.
	$lpm1 = $lastpage - 1;								//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<ul class=\"pagination\"";
		if($margin || $padding)
		{
			$pagination .= " style=\"";
			if($margin)
				$pagination .= "margin: $margin;";
			if($padding)
				$pagination .= "padding: $padding;";
			$pagination .= "\"";
		}
		$pagination .= ">";

		//previous button
		if ($page > 1) 
			$pagination .= "<li><a href=\"$targetpage$pagestring$prev\">«</a></li>";
		else
			$pagination .= "<li class=\"disabled\"><a href=\"$targetpage$pagestring$prev\">«</a></li>";
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination .= "<li class=\"active\"><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";
				else
					$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";					
			}
		}
		elseif($lastpage >= 7 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 3))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination .= "<li class=\"active\"><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";
					else
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";					
				}
				$pagination .= "<li><span class=\"elipses disabled\">...</span></li>";
				$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a></li>";
				$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a></li>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "1\">1</a></li>";
				$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "2\">2</a></li>";
				$pagination .= "<li><span class=\"elipses disabled\">...</span></li>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<li class=\"active\"><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";
					else
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";					
				}
				$pagination .= "<li><span class=\"elipses disabled\">...</span></li>";
				$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lpm1 . "\">$lpm1</a></li>";
				$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $lastpage . "\">$lastpage</a></li>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "1\">1</a></li>";
				$pagination .= "<li><a href=\"" . $targetpage . $pagestring . "2\">2</a></li>";
				$pagination .= "<li><span class=\"elipses disabled\">...</span></li>";
				for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<li class=\"active\"><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";
					else
						$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $counter . "\">$counter</a></li>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination .= "<li><a href=\"" . $targetpage . $pagestring . $next . "\">»</a></li>";
		else
			$pagination .= "<li><span class=\"disabled\">»</span></li>";
		$pagination .= "</div>\n";
	}
	
	return $pagination;

	}
          function implodef($string,$data) {
                $return = '';
                foreach($data as $item) {
                        $return .= sprintf($string,$item);
                }
                return $return;
        }


}
