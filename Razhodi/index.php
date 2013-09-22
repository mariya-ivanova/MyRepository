<?php
$pageTitle='Списък';
include 'includes/header.php';
?>
<a href="form.php">Добави нов разход</a>

<form method="POST">
	<div>
    <span>Вид:
        <select name="type">
			<?php if(!$_POST['type']||$_POST['type'] == 'all') { 	
				echo '<option value="all" selected >Всички</option>'; 				
				foreach ($type as $key=>$type_value) {						
					echo '<option value="'.$key.'">' . $type_value . '</option>';
				}
			} 
			else {				
				echo '<option value="all" >Всички</option>';									
				foreach ($type as $key=>$type_value) {
					if ($_POST['type'] == $key) {$selected = 'selected';}
					else {$selected = '';}
					echo '<option value="'.$key.'"'.$selected.'>' . $type_value . '</option>';
				}
			}
            ?>		
        </select> 

    </span>  
	<span><input type="submit" value="Филтрирай" /></span>
    </div>
</form>

<table border="1">
    <tr>
		<td>Дата</td>	
        <td>Име</td>
        <td>Сума</td>
        <td>Вид</td>
    </tr>
    <?php
	$sum=0;
    if(file_exists('data.txt')){
        $result=  file('data.txt');
	
        foreach ($result as $value) {						
            $columns=  explode('!', $value);  				 							
			if($_POST){
				$selected_type=trim($_POST['type']);	
				if((int)$columns[3] == $selected_type || $selected_type == 'all'){			
					echo '<tr>
						<td>'.$columns[0].'</td>
						<td>'.$columns[1].'</td>
						<td>'.$columns[2].'</td>
						<td>'.$type[trim($columns[3])].'</td>
						</tr>';
					$sum+= (float)$columns[2];
				}					
			}
			else {
				echo '<tr>
					<td>'.$columns[0].'</td>
					<td>'.$columns[1].'</td>
					<td>'.$columns[2].'</td>
					<td>'.$type[trim($columns[3])].'</td>
					</tr>';		
				$sum+= (float)$columns[2];
			}					
        }
		$sum = round($sum, 2);
    } 		
    ?>
		
	<tr>
		<td> -- </td>	
		<td> -- </td>
		<td><?php echo $sum ?></td>
		<td> -- </td>
	</tr>      
</table>

<?php
include 'includes/footer.php';
?>
