<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<?php
// Iniciamos la sesión para poder guardar datos entre recargas de la página
session_start();

// Si la lista no existe en la sesión, la creamos vacía
if (!isset($_SESSION['list'])) {
    $_SESSION['list'] = [];
}

// Variables para los mensajes y los valores de los campos del formulario
$error = "";
$message = "";
$name = "";
$quantity = "";
$price = "";
$index = -1;

// esto sirve para comprobar si se a enviado el formulario en nuestro casos e envia en POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // aqui en la variable POST añadimos un Add que nos sirve para agregar
    if (isset($_POST['add'])) {
        $name = trim($_POST['name']);
        $quantity = (int) $_POST['quantity'];
        $price = (float) $_POST['price'];

        // Comprobamos que los valores sean correctos
        if ($name != "" && $quantity > 0 && $price > 0) {
            $_SESSION['list'][] = ['name' => $name, 'quantity' => $quantity, 'price' => $price];
            $message = "Producto añadido correctamente.";
        } else {
            $error = "Error.";
        }
    }

    // aqui con el boton edit lo utilizamos para editar los datos del formulario
    if (isset($_POST['edit'])) {
        $name = $_POST['name'];
        $quantity = $_POST['quantity'];
        $price = $_POST['price'];
        $index = $_POST['index'];
    }

    // el update para actualizar
    if (isset($_POST['update'])) {
        $index = (int) $_POST['index'];
        $name = trim($_POST['name']);
        $quantity = (int) $_POST['quantity'];
        $price = (float) $_POST['price'];

        if ($index >= 0 && isset($_SESSION['list'][$index]) && $name != "" && $quantity > 0 && $price > 0) {
            $_SESSION['list'][$index] = ['name' => $name, 'quantity' => $quantity, 'price' => $price];
            $message = "Producto actualizado correctamente.";
        } else {
            $error = "Error al actualizar.";
        }
    }

    // y con el delete es simplemente para eliminar
    if (isset($_POST['delete'])) {
        $index = (int) $_POST['index'];
        if ($index >= 0 && isset($_SESSION['list'][$index])) {
            array_splice($_SESSION['list'], $index, 1);
            $message = "Producto eliminado.";
        } else {
            $error = "Error al eliminar.";
        }
    }

    // aqui el reset lo utilizamos para una vez que tenemos la lista la queremos reinicar
    if (isset($_POST['reset'])) {
        $_SESSION['list'] = [];
        $message = "reiniciado.";
    }

    // aqui oara calcular el total de la lista de lo que hemos comprado
    if (isset($_POST['total'])) {
        $totalValue = 0;
        foreach ($_SESSION['list'] as $item) {
            $totalValue += $item['quantity'] * $item['price'];
        }
        $message = "El costo total es: $" . number_format($totalValue, 2);
    }
}

$totalValue = 0;
foreach ($_SESSION['list'] as $item) {
    $totalValue += $item['quantity'] * $item['price'];
}
?>


<title>Shopping list</title>
    <style>
        table,
        th,
        td {
            border: 1px solid black;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 5px;
        }

        input[type=submit] {
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <h1>Shopping list</h1>
    <form method="post">
        <label for="name">name:</label>
        <input type="text" name="name" id="name" value="<?php echo $name; ?>">
        <br>
        <label for="quantity">quantity:</label>
        <input type="number" name="quantity" id="quantity" value="<?php echo $quantity; ?>">
        <br>
        <label for="price">price:</label>
        <input type="number" name="price" id="price" value="<?php echo $price; ?>">
        <br>
        <input type="hidden" name="index" value="<?php echo $index; ?>">
        <input type="submit" name="add" value="Add">
        <input type="submit" name="update" value="Update">
        <input type="submit" name="reset" value="Reset">
    </form>
    <p style="color:red;"><?php echo $error; ?></p>
    <p style="color:green;"><?php echo $message; ?></p>
    <table>
        <thead>
            <tr>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>cost</th>
                <th>actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($_SESSION['list'] as $index => $item) { ?>
                <tr>
                    <td><?php echo $item['name']; ?></td>
                    <td><?php echo $item['quantity']; ?></td>
                    <td><?php echo $item['price']; ?></td>
                    <td><?php echo $item['quantity'] * $item['price']; ?></td>
                    <td>
                        <form method="post">
                            <input type="hidden" name="name" value="<?php echo $item['name']; ?>">
                            <input type="hidden" name="quantity" value="<?php echo $item['quantity']; ?>">
                            <input type="hidden" name="price" value="<?php echo $item['price']; ?>">
                            <input type="hidden" name="index" value="<?php echo $index; ?>">
                            <input type="submit" name="edit" value="Edit">
                            <input type="submit" name="delete" value="Delete">
                        </form>
                    </td>
                </tr>
            <?php } ?>
            <tr>
                <td colspan="3" align="right"><strong>Total:</strong></td>
                <td><?php echo $totalValue; ?></td>
                <td>
                    <form method="post">
                        <input type="submit" name="total" value="Calculate total">
                    </form>
                </td>
            </tr>
        </tbody>
    </table>





    
</body>
</html>
