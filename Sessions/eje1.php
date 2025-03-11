<!DOCTYPE html>
<html lang="en">
 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
   
</head>
 
<body>
 
    <?php //PARTE PHP
    // Start the session
    session_start();
 
    // Initialize session variables if not already set
    if (!isset($_SESSION['quatityMilk'])) {
        $_SESSION['quatityMilk'] = 0;
    }
    if (!isset($_SESSION['quatitySoftDrink'])) {
        $_SESSION['quatitySoftDrink'] = 0;
    }
 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Get form data
        $worker = $_POST['worker'];
        $product = $_POST['product'];
        $quantity = $_POST['quantity'];
 
        if (isset($_POST["add"])) {
            // Evaluate product
            switch ($product) {
                case 'milk':
                    // Add quantity to corresponding product
                    $_SESSION['quatityMilk'] += $quantity;
                    break;
 
                case 'softDrink':
                    // Add quantity to corresponding product
                    $_SESSION['quatitySoftDrink'] += $quantity;
                    break;
 
                default:
                    echo "<br> <font color='red'><p>Error: Product not found. </p></font>";
                    break;
            }
        } elseif (isset($_POST["remove"])) {
            // Evaluate product
            switch ($product) {
                case 'milk':
                    // Remove quantity from corresponding product
                    $_SESSION['quatityMilk'] = max(0, $_SESSION['quatityMilk'] - $quantity);
                    break;
 
                case 'softDrink':
                    // Remove quantity from corresponding product
                    $_SESSION['quatitySoftDrink'] = max(0, $_SESSION['quatitySoftDrink'] - $quantity);
                    break;
 
                default:
                    echo "<br> <font color='red'><p>Error: Product not found. </p></font>";
                    break;
            }
        } elseif (isset($_POST["reset"])) {
            // Reset quantities
            $_SESSION['quatityMilk'] = 0;
            $_SESSION['quatitySoftDrink'] = 0;
        }
    }
    ?>
 

    <h1>Supermercat management</h1>
 
    <form method="POST">
        <label for="worker"> Worker name: </label>
        <input type="text" id="worker" name="worker"
            value="<?php echo isset($_POST['worker']) ? $_POST['worker'] : ''; ?>"> <br><br>
        <h3>Choose product:</h3>
 
        <label for="product"></label>
        <select name="product" id="product" required>
            <option value="softDrink">soft drink</option>
            <option value="milk">Milk</option>
        </select><br><br>
 
        <h3>Product quantity:</h3>
 
        <input type="number" id="quantity" name="quantity" min="1" max="25"><br>
        <input type="submit" value="add" name="add">
        <input type="submit" value="remove" name="remove">
        <input type="submit" value="reset" name="reset"></input>
 
        <h3>Inventary: </h3>
 
        <p>Worker: <?php echo isset($worker) ? $worker : ""; ?></p>
        <p>Unit milk: <?php echo $_SESSION['quatityMilk']; ?></p>
        <p>Unit Soft: <?php echo $_SESSION['quatitySoftDrink']; ?></p>
       
    </form>
 
</body>
 
</html>