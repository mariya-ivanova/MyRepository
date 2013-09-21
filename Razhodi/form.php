<?php
mb_internal_encoding('UTF-8');
$pageTitle = 'Форма';
include 'includes/header.php';

if($_POST){
	$date = date("d.m.Y");	
    $costname=trim($_POST['costname']);
    $costname=  str_replace('!', '', $costname);
    $cost=trim($_POST['cost']);
    $cost=  (float)str_replace('!', '', $cost);
    $selectedType=(int)$_POST['type'];
    $error=false;
    if(mb_strlen($costname)<4){
        echo '<p>Името е прекалено късо</p>';
        $error=true;
    }
    
    if($cost<0){
        echo '<p>невалидна сума</p>';
        $error=true;
    }    
    if(!array_key_exists($selectedType, $type)){
        echo '<p>невалиден тип разход</p>';
        $error=true;
    }    
	
    if(!$error){
        $result=$date.'!'.$costname.'!'.$cost.'!'.$selectedType."\n";
        if(file_put_contents('data.txt', $result,FILE_APPEND))
        {
            echo 'Записът е успешен';
        }
    }
        
}

?>
<a href="index.php">Списък</a>

<form method="POST">
    <div>Име:<input type="text" name="costname" /></div>
    <div>Сума:<input type="text" name="cost" /></div>
    <div>Вид:
        <select name="type">
            <?php
            foreach ($type as $key=>$value) {
                echo '<option value="'.$key.'">' . $value .
                        '</option>';
            }
            ?>
        </select>           
    </div>        
    <div><input type="submit" value="Добави" /></div>
</form>
<?php
include 'includes/footer.php';
?>