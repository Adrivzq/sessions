<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
</head>
<body>
    
<?php

session_start();

// Inicializar el array en la primera ejecución
if (!isset($_SESSION['numbers'])) {
    $_SESSION['numbers'] = array(10, 20, 30);
}

// Verificar si el formulario ha sido enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Modificar un valor en la posición especificada
    if (isset($_POST["modify"])) {
        // Obtener los datos del formulario y validar que sean numéricos
        $position = isset($_POST['position']) ? filter_var($_POST['position'], FILTER_VALIDATE_INT) : null;
        $value = isset($_POST['value']) ? filter_var($_POST['value'], FILTER_VALIDATE_INT) : null;

        // Modificar la posición seleccionada si es válida
        if ($position !== false && $value !== false && isset($_SESSION['numbers'][$position])) {
            $_SESSION['numbers'][$position] = $value;
            echo "modificacion.";
        } else {
            echo "Error";
        }
    }

    // Calcular el promedio
    elseif (isset($_POST["average"])) {
        if (!empty($_SESSION['numbers'])) {
            $average = array_sum($_SESSION['numbers']) / count($_SESSION['numbers']);
            $average = number_format($average, 2);
            echo "$average";
        } else {
            echo "Error:";
        }
    }
}
?>

<h2> Modify array saved in session </h2>
<form method="POST">

<label for="position"> position to Modify: </label>
 <select name="position to Modify" id="position to Modify" required>
     <option value="0">0</option>
     <option value="1">1</option>
     <option value="2">2</option>
     <option value="3">3</option>
 </select><br><br>


 <label for="value"> New value: </label>
   <input type="text" id="value" name="new value"
     value="<?php echo isset($_POST['value']) ? $_POST['Value'] : ''; ?>"> <br><br>

<input type="submit" value="Modify" name="Modify">
<input type="submit" value="Average" name="Average">
<input type="submit" value="Reset" name="Reset"></input>


<p> current array: <?php echo $_SESSION['numbers'] ?> </p>


</form>















 
 





 



</body>
</html>