<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character encoding for the document -->
    <meta charset="UTF-8">
    <!-- Viewport settings for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title of the page -->
    <title>SCP Foundation - Create</title>
    <!-- Link to the external CSS stylesheet for styling -->
    <link rel="stylesheet" href="styles/main.css">
</head>

<body>
    <!-- Main Content Area -->
    <main class="folder">
        <!-- Link to close the folder and return to the index page -->
        <a href="index.php" class="folder-link"><strong>CLOSE</strong></a>
        <div class="content">
            <!-- Navigation Menu -->
            <nav>
                <!-- Links to SCP pages -->
                <a href="home.php" class="active">HOME</a> <!-- Current page (HOME) highlighted -->
                <!-- Include database connection -->
                <?php include "connection.php"; ?> 
                <?php foreach($result as $link): ?>
                <a href="home.php?link=<?php echo $link['item'] ; ?>" class="active"><?php echo $link['item']; ?></a>
                <?php endforeach; ?>
            </nav>
            <!-- Section for Home page content -->
            <section class="page">
                <?php
                    include "connection.php";
                    if(isset($_POST['submit']))
                    {
                        // Write a prepared statement to insert data
                        $insert = $connection->prepare("insert into scp(item, object_class, image, special_containment_procedure, description) values(?,?,?,?,?)");
                        $insert->bind_param("sssss", $_POST['item'], $_POST['object_class'], $_POST['image'], $_POST['special_containment_procedure'], $_POST['description']);
                        if($insert->execute())
                        {
                            echo "
                                <div>Record successfully created</div>
                            ";
                        }
                        else
                        {
                            echo "
                                <div>Error: {$insert->error}</div>
                            ";
                        }
                    }
                ?>
                <h1>Create a new record.</h1>
                <p><a href="home.php">Back to home page.</a></p>
                <div>
                    <form method="post" action="create.php">
                        <label>Enter SCP Item:</label>
                        <br>
                        <input type="text" name="item" placeholder="e.g. SCP001..." required>
                        <br><br>
                        <label>Enter Object Class:</label>
                        <br>
                        <input type="text" name="object_class" placeholder="e.g. Euclid...">
                        <br><br>
                        <label>Enter Image:</label>
                        <br>
                        <input type="text" name="image" placeholder="e.g. images/nameofimage.png...">
                        <br><br>
                        <label>Enter SCP:</label>
                        <br>
                        <input type="text" name="special_containment_procedure" placeholder="e.g. Special Containment Procedure...">
                        <br><br>
                        <label>Enter Description:</label>
                        <br>
                        <textarea name="description"></textarea>
                        <br>
                        <input type="submit" name="submit">
                    </form>
                </div>
                <!-- Footer Section -->
                <footer>
                    <!-- Link to return to the top of the page -->
                    <a href="home.php">
                        <h5>Back to Top</h5>
                    </a>
                    <!-- Footer content with copyright notice -->
                    <h6>&copy; 2024 SCP Foundation. All rights reserved.</h6>
                </footer>
            </section>
        </div>
    </main>
    <!-- Link to the external JavaScript file for interactivity -->
    <script src="scripts/main.js"></script>
</body>

</html>