<?php
$pageTitle='Списък';
include 'includes/header.php';
if (isset($_GET['message'])) {
	if ($_GET['message'] == 'success') {echo 'Успешно изтрит запис.<br/>';} 
}
?>
<a href="form.php">Добави нов разход</a>

<form method="POST">
	<div>
    <span>Вид:
        <select name="type">			
			<?php 
			/* да се показва избраната стойност, а не тази по подразбиране */
			if(!$_POST['type']||$_POST['type'] == 'all') { 	
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
		<td>Изтрий</td>
    </tr>
    <?php
	$sum=0;
    if(file_exists('data.txt')){
        $result= file('data.txt');
		
        foreach ($result as $row=>$value) {						
            $columns=  explode('!', $value);  	
			if (count($columns) < 4) {
                continue;
            }
			if($_POST){				
				$selected_type=trim($_POST['type']);	
				/* да се показват само разходите за избрания филтър и тяхната сума */
				if((int)$columns[3] == $selected_type || $selected_type == 'all'){			
					echo '<tr>
						<td>'.$columns[0].'</td>
						<td>'.$columns[1].'</td>
						<td>'.number_format($columns[2], 2).'</td>
						<td>'.$type[trim($columns[3])].'</td>
						<td>
							<a href="delete.php?delete_element='.$row.'">Изтрий</a>
							
						</td>
						</tr>';
					$sum+= (float)$columns[2];
				}					
			}
			/* при първоначално зареждане на страницата да се показват всички разходи и тяхната сума */
			else {
				echo '<tr>
					<td>'.$columns[0].'</td>
					<td>'.$columns[1].'</td>
					<td>'.number_format($columns[2], 2).'</td>
					<td>'.$type[trim($columns[3])].'</td>
					<td>
						<a href="delete.php?delete_element='.$row.'">Изтрий</a>
					</td>					
					</tr>';		
				$sum+= (float)$columns[2];
			}					
        }
		$sum = number_format($sum, 2);
    } 		
    ?>
		
	<tr>
		<td> -- </td>	
		<td> -- </td>
		<td><?php echo $sum ?></td>
		<td> -- </td>
		<td> -- </td>
	</tr>      
</table>

<?php
include 'includes/footer.php';
?>	