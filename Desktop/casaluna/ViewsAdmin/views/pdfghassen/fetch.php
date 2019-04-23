<?php

//fetch.php

include('database_connection.php');

$column = array('id_event', 'nome', 'lieu', 'dateexpo');

$query = "SELECT * FROM event ";

if(isset($_POST['search']['value']))
{
 $query .= '
 WHERE id_event LIKE "%'.$_POST['search']['value'].'%" 
 OR nome LIKE "%'.$_POST['search']['value'].'%" 
 OR lieu LIKE "%'.$_POST['search']['value'].'%" 
 OR dateexpo LIKE "%'.$_POST['search']['value'].'%" 
 ';
}

if(isset($_POST['order']))
{
 $query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
 $query .= 'ORDER BY id_event DESC ';
}

$query1 = '';

if($_POST['length'] != -1)
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
 $sub_array[] = $row['id_event'];
 $sub_array[] = $row['nome'];
 $sub_array[] = $row['lieu'];
 $sub_array[] = $row['dateexpo'];
 $data[] = $sub_array;
}

function count_all_data($connect)
{
 $query = "SELECT * FROM event";
 $statement = $connect->prepare($query);
 $statement->execute();
 return $statement->rowCount();
}

$output = array(
 'draw'    => intval($_POST['draw']),
 'recordsTotal'  => count_all_data($connect),
 'recordsFiltered' => $number_filter_row,
 'data'    => $data
);

echo json_encode($output);

?>