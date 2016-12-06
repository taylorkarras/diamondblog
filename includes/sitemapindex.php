<?php
header("Content-type: text/xml");
echo '<?xml version="1.0" encoding="UTF-8"?>';
  echo '<sitemapindex xmlns="https://www.sitemaps.org/schemas/sitemap/0.9">';
  $global = new DB_global;
  $postcount = $global->sqlquery("SELECT * FROM dd_content LIMIT 0, 50000");
  $lastmodified = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, 50000");
  $lastmodifieddate = $lastmodified->fetch_assoc();
  if ($postcount->num_rows < '50000') {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/1</loc>';
	$dateTime = date_create($lastmodifieddate['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W3C).'</lastmod>';
echo '</sitemap>';
  }
  $times2 = '50000' * 2;
  $postcount2 = $global->sqlquery("SELECT * FROM dd_content LIMIT 50000, ".$times2."");
  $lastmodified2 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times2."");
  $lastmodifieddate2 = $lastmodified2->fetch_assoc();
    if ($postcount2->num_rows > '50000') {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/2</loc>';
	$dateTime = date_create($lastmodifieddate2['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W3C).'</lastmod>';
echo '</sitemap>';
	}
  $times3 = '50000' * 3;
  $postcount3 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times2.", ".$times3."");
  $lastmodified3 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times3."");
  $lastmodifieddate3 = $lastmodified2->fetch_assoc();
    if ($postcount3->num_rows > '50000' * 2) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/3</loc>';
	$dateTime = date_create($lastmodifieddate3['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W3C).'</lastmod>';
echo '</sitemap>';
	}
  $times4 = '50000' * 4;
  $postcount4 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times3.", ".$times4."");
  $lastmodified4 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times4."");
  $lastmodifieddate4 = $lastmodified3->fetch_assoc();
    if ($postcount4->num_rows > '50000' * 3) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/4</loc>';
	$dateTime = date_create($lastmodifieddate4['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W4C).'</lastmod>';
echo '</sitemap>';
	}
  $times5 = '50000' * 5;
  $postcount5 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times4.", ".$times5."");
  $lastmodified5 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times5."");
  $lastmodifieddate5 = $lastmodified4->fetch_assoc();
    if ($postcount5->num_rows > '50000' * 4) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/5</loc>';
	$dateTime = date_create($lastmodifieddate5['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W5C).'</lastmod>';
echo '</sitemap>';
	}
  $times6 = '50000' * 6;
  $postcount6 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times5.", ".$times6."");
  $lastmodified6 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times6."");
  $lastmodifieddate6 = $lastmodified5->fetch_assoc();
    if ($postcount6->num_rows > '50000' * 5) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/6</loc>';
	$dateTime = date_create($lastmodifieddate6['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W6C).'</lastmod>';
echo '</sitemap>';
	}
  $times7 = '50000' * 7;
  $postcount7 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times6.", ".$times7."");
  $lastmodified7 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times7."");
  $lastmodifieddate7 = $lastmodified6->fetch_assoc();
    if ($postcount7->num_rows > '50000' * 6) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/7</loc>';
	$dateTime = date_create($lastmodifieddate7['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W7C).'</lastmod>';
echo '</sitemap>';
	}
echo   $times8 = '50000' * 8;
  $postcount8 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times7.", ".$times8."");
  $lastmodified8 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times8."");
  $lastmodifieddate8 = $lastmodified7->fetch_assoc();
    if ($postcount8->num_rows > '50000' * 7) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/8</loc>';
	$dateTime = date_create($lastmodifieddate8['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W8C).'</lastmod>';
echo '</sitemap>';
	}
  $times9 = '50000' * 9;
  $postcount9 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times8.", ".$times9."");
  $lastmodified9 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times9."");
  $lastmodifieddate9 = $lastmodified8->fetch_assoc();
    if ($postcount9->num_rows > '50000' * 8) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/9</loc>';
	$dateTime = date_create($lastmodifieddate9['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W9C).'</lastmod>';
echo '</sitemap>';
	}
  $times10 = '50000' * 10;
  $postcount10 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times9.", ".$times10."");
  $lastmodified10 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times10."");
  $lastmodifieddate10 = $lastmodified9->fetch_assoc();
    if ($postcount10->num_rows > '50000' * 9) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/10</loc>';
	$dateTime = date_create($lastmodifieddate10['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W10C).'</lastmod>';
echo '</sitemap>';
	}
  $times11 = '50000' * 11;
  $postcount11 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times10.", ".$times11."");
  $lastmodified11 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times11."");
  $lastmodifieddate11 = $lastmodified10->fetch_assoc();
    if ($postcount11->num_rows > '50000' * 10) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/11</loc>';
	$dateTime = date_create($lastmodifieddate11['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W11C).'</lastmod>';
echo '</sitemap>';
	}
  $times12 = '50000' * 12;
  $postcount12 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times11.", ".$times12."");
  $lastmodified12 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times12."");
  $lastmodifieddate12 = $lastmodified11->fetch_assoc();
    if ($postcount12->num_rows > '50000' * 11) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/12</loc>';
	$dateTime = date_create($lastmodifieddate12['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W12C).'</lastmod>';
echo '</sitemap>';
	}
  $times13 = '50000' * 13;
  $postcount13 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times12.", ".$times13."");
  $lastmodified13 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times13."");
  $lastmodifieddate13 = $lastmodified12->fetch_assoc();
    if ($postcount13->num_rows > '50000' * 12) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/13</loc>';
	$dateTime = date_create($lastmodifieddate13['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W13C).'</lastmod>';
echo '</sitemap>';
	}
  $times14 = '50000' * 14;
  $postcount14 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times13.", ".$times14."");
  $lastmodified14 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times14."");
  $lastmodifieddate14 = $lastmodified13->fetch_assoc();
    if ($postcount14->num_rows > '50000' * 13) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/14</loc>';
	$dateTime = date_create($lastmodifieddate14['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W14C).'</lastmod>';
echo '</sitemap>';
	}
  $times15 = '50000' * 15;
  $postcount15 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times14.", ".$times15."");
  $lastmodified15 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times15."");
  $lastmodifieddate15 = $lastmodified14->fetch_assoc();
    if ($postcount15->num_rows > '50000' * 14) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/15</loc>';
	$dateTime = date_create($lastmodifieddate15['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W15C).'</lastmod>';
echo '</sitemap>';
	}
  $times16 = '50000' * 16;
  $postcount16 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times15.", ".$times16."");
  $lastmodified16 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times16."");
  $lastmodifieddate16 = $lastmodified15->fetch_assoc();
    if ($postcount16->num_rows > '50000' * 15) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/16</loc>';
	$dateTime = date_create($lastmodifieddate16['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W16C).'</lastmod>';
echo '</sitemap>';
	}
  $times17 = '50000' * 17;
  $postcount17 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times16.", ".$times17."");
  $lastmodified17 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times17."");
  $lastmodifieddate17 = $lastmodified15->fetch_assoc();
    if ($postcount17->num_rows > '50000' * 16) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/17</loc>';
	$dateTime = date_create($lastmodifieddate17['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W17C).'</lastmod>';
echo '</sitemap>';
	}
  $times18 = '50000' * 18;
  $postcount18 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times17.", ".$times18."");
  $lastmodified18 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times18."");
  $lastmodifieddate18 = $lastmodified15->fetch_assoc();
    if ($postcount18->num_rows > '50000' * 17) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/18</loc>';
	$dateTime = date_create($lastmodifieddate18['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W18C).'</lastmod>';
echo '</sitemap>';
	}
  $times19 = '50000' * 19;
  $postcount19 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times18.", ".$times19."");
  $lastmodified19 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times19."");
  $lastmodifieddate19 = $lastmodified15->fetch_assoc();
    if ($postcount19->num_rows > '50000' * 18) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/19</loc>';
	$dateTime = date_create($lastmodifieddate19['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W19C).'</lastmod>';
echo '</sitemap>';
	}
  $times20 = '50000' * 20;
  $postcount20 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times19.", ".$times20."");
  $lastmodified20 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times20."");
  $lastmodifieddate20 = $lastmodified15->fetch_assoc();
    if ($postcount20->num_rows > '50000' * 19) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/20</loc>';
	$dateTime = date_create($lastmodifieddate20['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W20C).'</lastmod>';
echo '</sitemap>';
	}
  $times21 = '50000' * 21;
  $postcount21 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times20.", ".$times21."");
  $lastmodified21 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times21."");
  $lastmodifieddate21 = $lastmodified15->fetch_assoc();
    if ($postcount21->num_rows > '50000' * 20) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/21</loc>';
	$dateTime = date_create($lastmodifieddate21['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W21C).'</lastmod>';
echo '</sitemap>';
	}
  $times22 = '50000' * 22;
  $postcount22 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times21.", ".$times22."");
  $lastmodified22 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times22."");
  $lastmodifieddate22 = $lastmodified15->fetch_assoc();
    if ($postcount22->num_rows > '50000' * 21) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/22</loc>';
	$dateTime = date_create($lastmodifieddate22['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W22C).'</lastmod>';
echo '</sitemap>';
	}
  $times23 = '50000' * 23;
  $postcount23 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times22.", ".$times23."");
  $lastmodified23 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times23."");
  $lastmodifieddate23 = $lastmodified15->fetch_assoc();
    if ($postcount23->num_rows > '50000' * 22) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/23</loc>';
	$dateTime = date_create($lastmodifieddate23['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W23C).'</lastmod>';
echo '</sitemap>';
	}
  $times24 = '50000' * 24;
  $postcount24 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times23.", ".$times24."");
  $lastmodified24 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times24."");
  $lastmodifieddate24 = $lastmodified15->fetch_assoc();
    if ($postcount24->num_rows > '50000' * 23) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/24</loc>';
	$dateTime = date_create($lastmodifieddate24['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W24C).'</lastmod>';
echo '</sitemap>';
	}
  $times25 = '50000' * 25;
  $postcount25 = $global->sqlquery("SELECT * FROM dd_content LIMIT ".$times23.", ".$times25."");
  $lastmodified25 = $global->sqlquery("SELECT content_date FROM dd_content LIMIT 1, ".$times25."");
  $lastmodifieddate25 = $lastmodified15->fetch_assoc();
    if ($postcount25->num_rows > '50000' * 23) {
echo '<sitemap>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/sitemap/25</loc>';
	$dateTime = date_create($lastmodifieddate25['content_date']);
    echo '<lastmod>'.$dateTime->format(DateTime::W25C).'</lastmod>';
echo '</sitemap>';
	}
echo '</sitemapindex>';
exit;
?>
