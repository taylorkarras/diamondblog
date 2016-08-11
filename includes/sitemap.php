<?php
header("Content-type: text/xml");
$global = new DB_global;
$url = explode('/', $_SERVER['REQUEST_URI']);
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';
if ($url[2] == '1'){
$posts = $global->sqlquery("SELECT * FROM dd_content LIMIT 0, 50000");
if ($posts->num_rows < '50000') {
while($row = $posts->fetch_assoc()) {
echo '<url>';
echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/'.$row['content_permalink'].'</loc>';
echo '</url>';
}
}
} else if ($url[2] == '2') {
$posts = $global->sqlquery("SELECT * FROM dd_content LIMIT 50000, 100000");
if ($posts->num_rows > '50000') {
while($row = $posts->fetch_assoc()) {
echo '<url>';
echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/'.$row['content_permalink'].'</loc>';
echo '</url>';
}
}
} else if ($url[2] > '2') {
$number1 = '50000' * $url[2];
$number2 = '100000' * $url[2];
$posts = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$number1.", ".$number2."");
if ($posts->num_rows > '50000' * $url[2]) {
while($row = $posts->fetch_assoc()) {
echo '<url>';
echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/'.$row['content_permalink'].'</loc>';
echo '</url>';
}
}	
}
echo '</urlset>';
exit;
?>