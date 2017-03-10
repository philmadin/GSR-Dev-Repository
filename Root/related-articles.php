<?php
function formatNum($num) {
    if(!isset($num)){return false;}
    $x = round($num);
    $x_number_format = number_format($x);
    $x_array = explode(',', $x_number_format);
    $x_parts = array('k', 'm', 'b', 't');
    $x_count_parts = count($x_array) - 1;
    $x_display = $x;
    $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
    $x_display .= $x_parts[$x_count_parts - 1];
    return $x_display;
}

function most_relevant($a, $b){
	global $title;
	$t1 = levenshtein($title, $b['title']);
	$t2 = levenshtein($title, $a['title']);
	return $t2 - $t1;
}

function relatedArticles($tags, $articletype, $num=3, $title)
{

    include 'mysql_con.php';
    $tag_ar = explode(", ", $tags);
    $query_parts = array();
    foreach ($tag_ar as $val) {
        $query_parts[] = '"%' . mysqli_real_escape_string($con, $val) . '%"';
    }

    $tagString = implode(' OR tags LIKE ', $query_parts);

    $articletype = strtolower($articletype);
    $relatedArticles = mysqli_query($con, 'SELECT * FROM tbl_' . $articletype . ' WHERE (tags LIKE ' . $tagString . ') AND alpha_approved="true"');

    $articleList = array();

    while ($relROW = mysqli_fetch_assoc($relatedArticles)) {
        $articleList[] = $relROW;
    }

    usort($articleList, "most_relevant");
    if (preg_match('#[0-9]#',$title)){

        uasort($articleList, function($a, $b) {
            return strnatcmp($a['title'], $b['title']);
        });
    }

    for ($x = 0; $x <= (count($articleList)-1); $x++) {
        if($articleList[$x]['title']==$title){unset($articleList[$x]);}
    }

    return array_slice($articleList, 0, $num);

}

?>