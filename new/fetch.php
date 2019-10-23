<?php
$dsn = "mysql:host=localhost; dbname=sample;";
$db_user = "root";
$db_pass = "";

$con = new pdo($dsn,$db_user,$db_pass);
$column = array('Column1','Column2','Column3','Column4','Column5', );
$query = "SELECT * FROM tableName";
if(isset($_POST['group_type'],$_POST['group_date']) && $_POST['group_type'] != '' && $_POST['group_type'] != '')
{
	$query .= 'WHERE group_type = "'.$_POST['group_type'].'"AND group_date = " '.$_POST['group_date'].' "';
}
if(isset($_POST['order']))
{
$query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
$query .= 'ORDER BY CustomerID DESC ';
}


$query1 = '';

if($_POST["length"] != -1)
{
 $query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$statement = $connect->prepare($query . $query1);

$statement->execute();

$result = $statement->fetchAll();



$data = array();

foreach($result as $row)
{
 $sub_array = array();
 $sub_array[] = $row['CustomerName'];
 $sub_array[] = $row['Gender'];
 $sub_array[] = $row['Address'];
 $sub_array[] = $row['City'];
 $sub_array[] = $row['PostalCode'];
 $sub_array[] = $row['Country'];
 $data[] = $sub_array;
}

function count_all_data($connect)
{
 $query = "SELECT * FROM tbl_customer";
 $statement = $connect->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}

$output = array(
 "draw"       =>  intval($_POST["draw"]),
 "recordsTotal"   =>  count_all_data($connect),
 "recordsFiltered"  =>  $number_filter_row,
 "data"       =>  $data
);

echo json_encode($output);

?>

?>