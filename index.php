<?php 
$currentPage = $_GET['page'] ?? 1;
$ourData = file_get_contents("data.json");
$testData = json_decode($ourData,true);
usort($testData, "cmp");
$pageCount = (int)count($testData) / 10;
$showingData = array_slice($testData,($currentPage - 1)*10 , 10);
//TODO: Доделать фильтр
if(isset($_GET["search"])){
				$age = $_GET["age"];
				function filt($var)
				{
						return $var & 1;
				}


				array_filter($showingData, "odd");

}




//TODO: Нужно что-то сделать с вариантами сортировок, пока что единственная идея это использовать битувую карту или через глобальную переменную что не очень желательно
function cmp($a, $b)
{
    if ($a["score"] == $b["score"]) {
        return 0;
    }
		return ($a["score"] > $b["score"]) ? -1 : 1;
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
    <title>Мегасупер список студентов</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="style.css" rel="stylesheet">
</head>

<body>
<div class="panel">
    <h3>Список студентов</h3>
    <form method="GET" class="panel__search">
        <h3>Поиск:</h3>
				<input type="text" name="search">
				<input type="submit" value="Найти">
    </form>

</div>
    <table>
        <thead>
            <tr>
                <th>Имя</th>
                <th>Фамилия</th>
                <th>Номер Группы</th>
                <th>Баллов ▲</th>
            </tr>
        </thead>
        <tbody>
<?php
foreach ($showingData as $element) {
?>
            <tr>
						<td><?=$element["name"]; ?>    </td>
						<td><?=$element["surname"]; ?>    </td>
						<td><?=$element["group"]; ?>    </td>
						<td><?=$element["score"]; ?>    </td>
            </tr>
<?php
}
?>
        </tbody>
    </table>
<p> 

<?php
$startPoint = $currentPage <= 5? 1: $currentPage - 5; 
$endPoint = $currentPage <= 5 ? 10:$currentPage + 4;
if ($currentPage == 1) {
				$startPoint = 1;
				$endPoint = 10;
} else if ( $currentPage == $pageCount) {
				$startPoint = $pageCount - 9;
				$endPoint = $pageCount;
} else {
				$startPoint = $currentPage - 5;
				$endPoint = $currentPage + 4;
}


for ($i = $startPoint;$i<=$endPoint; $i++) {
?>


<a 
href="<?='/?page='.$i?>"

>
<?=$i==$currentPage?"[".$i."]":$i?>
</a> 


<?php
}
?>
 </p>
</body>

</html>
