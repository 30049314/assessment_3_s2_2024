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
                    if($_GET['update'])
                    {
                        $id = $_GET['update'];
                        $recordID = $connection->prepare("select * from scp where id = ?");
                        if(!$recordID)
                        {
                            echo "<div>Error preparing record for updating.</div>";
                            exit;
                        }
                        $recordID->bind_param("i", $id);
                        if($recordID->execute())
                        {
                            echo "<div>Record ready for updating.</div>";
                            $temp = $recordID->get_result();
                            $row = $temp->fetch_assoc();
                        }
                        else
                        {
                            echo"<div>Error: {$recordID->error}</div>";
                        }
                    }
                    if(isset($_POST['update']))
                    {
                        // Write a prepared statement to insert data
                        $update = $connection->prepare("update scp set item=?, object_class=?, image=?, special_containment_procedure=?, description=? where id=?");
                        $update->bind_param("sssssi", $_POST['item'], $_POST['object_class'], $_POST['image'], $_POST['special_containment_procedure'], $_POST['description'], $_POST['id']);
                        if($update->execute())
                        {
                            echo "
                                <div>Record successfully updated</div>
                            ";
                        }
                        else
                        {
                            echo "
                                <div>Error: {$update->error}</div>
                            ";
                        }
                    }
                ?>
                <h1>Update record.</h1>
                <p><a href="home.php">Back to home page.</a></p>
                <div>
                    <form method="post" action="update.php">
                        <input type="hidden" name="id", value="<?php echo $row['id']; ?>">
                        <label>Item:</label>
                        <br>
                        <input type="text" name="item" placeholder="e.g. SCP001..." required value="<?php echo $row['item']; ?>">
                        <br><br>
                        <label>Object Class:</label>
                        <br>
                        <input type="text" name="object_class" placeholder="e.g. Euclid..." value="<?php echo $row['object_class']; ?>">
                        <br><br>
                        <label>Image:</label>
                        <br>
                        <input type="text" name="image" placeholder="e.g. images/nameofimage.png..." value="<?php echo $row['image']; ?>">
                        <br><br>
                        <label>SCP:</label>
                        <br>
                        <input type="text" name="special_containment_procedure" placeholder="e.g. Special Containment Procedure..." value="<?php echo $row['special_containment_procedure']; ?>">
                        <br><br>
                        <label>Description:</label>
                        <br>
                        <textarea name="description"><?php echo $row['description']; ?></textarea>
                        <br>
                        <input type="submit" name="update">
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