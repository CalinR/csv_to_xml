<?php
$name = $_FILES['csv']['name'];
$ext = strtolower(end(explode('.', $_FILES['csv']['name'])));
$type = $_FILES['csv']['type'];
$tmpName = $_FILES['csv']['tmp_name'];

$csv = array();

$row = 1;
ini_set('auto_detect_line_endings',TRUE);
if(($handle = fopen($tmpName, 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        for ($c=0; $c < $num; $c++) {

            $csv[$row][$c] = $data[$c];
        }
    }
    fclose($handle);
}
?>

<?php header("Content-type: text/xml"); ?>
<?php echo '
<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">';
echo "\n";
?>
<?php
$length = count($csv);

for ($d=3; $d < $length+2; $d++)
{
    echo "<url>\n";
    echo "<loc>" . $csv[$d][0] . "</loc>\n";
    echo "<changefreq>daily</changefreq>\n";
    echo "<priority>0.80</priority>\n";
    echo "<url>\n";
}
?>

<?php echo '</urlset>';?>
