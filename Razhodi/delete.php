<?php
mb_internal_encoding('UTF-8');
$pageTitle = 'Изтриване';
include 'includes/header.php';

if (isset($_GET['delete_element'])) {
	$row = $_GET['delete_element'];
    delete_entry($row);
}

?>
<a href="index.php">Списък</a>


<?php
include 'includes/footer.php';
?>
	
<?php

function delete_entry($row) {
    
    if (file_exists('data.txt')) {
        $file_content = file('data.txt');
		
		if (count($file_content) < $row) {
            echo 'Неуспешно изтриване.<a href="index.php">Назад</a>';                  
        }
		else {
			$newFileContent = str_replace($file_content[$row], '', $file_content);
			
			if(file_put_contents('data.txt', $newFileContent) &&
				file_put_contents('data.txt', "\n", FILE_APPEND)){
				/* преминаваме на следващия ред след края на файла, за да може при въвеждане на нов запис
					той да се запише на нов ред, а да не се "залепи" за последния ред. */
				
				header('Location:index.php?message=success');
				/* връщаме се на началната страница */ 
				/* ако останем в настоящата и презаредим страницата погрешка, 
				тъй като масивът от редове вече е с един по-малко, а стойността на $row е същата,
				ще се изтрие следващият ред от масива, което не бива да се случва */
				
			}	
			else echo 'Неуспешно изтриване.<a href="index.php">Назад</a>';  		
		}	
    }				
}

?>	