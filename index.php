<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

//start here

$result=array();
$player=json_decode(file_get_contents('php://input'), true)['input'];
$num=1;

for($i=0;$i<$player;$i++)
{
	$result[$num]='';
	$num++;
}

$cards= array('S-A','S-2','S-3','S-4','S-5','S-6','S-7','S-8','S-9','S-X','S-J','S-Q','S-K',
			  'H-A','H-2','H-3','H-4','H-5','H-6','H-7','H-8','H-9','H-X','H-J','H-Q','H-K',
			  'D-A','D-2','D-3','D-4','D-5','D-6','D-7','D-8','D-9','D-X','D-J','D-Q','D-K',
			  'C-A','C-2','C-3','C-4','C-5','C-6','C-7','C-8','C-9','C-X','C-J','C-Q','C-K');
shuffle($cards);

if($player<52)
{
	$balance=fmod(52,(int)$player);
	$each_player_get= (52-$balance) / $player;
	
	for($m=0;$m<$each_player_get;$m++)
	{
		foreach($result as $key => $value)
		{
			$result[$key]=$result[$key].",".array_shift($cards); 
		}
	}
	
	$n=1;
	while($n<= $balance)
	{
		$result[$n]=$result[$n].",".array_shift($cards); 
		$n++;
	}
}
elseif($player==52)
{
	foreach($result as $key => $value)
	{
		$result[$key]=$result[$key].",".array_shift($cards); 
	}
}
elseif($player>52)
{
	$n=1;
	while($n<=52)
	{
		$result[$n]=$result[$n].",".array_shift($cards); 
		$n++;
	}
}

$array1=array();

foreach($result as $key => $value)
{
	$val=ltrim($value,",");
	$array1[$key]=$val;
}

echo json_encode($array1);
?>
