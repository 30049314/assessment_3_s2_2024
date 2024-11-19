<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Character encoding for the document -->
    <meta charset="UTF-8">
    <!-- Viewport settings for responsive design -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Title of the page -->
    <title>SCP Foundation - Home</title>
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
                
                <!-- Title for the Home page -->
                <h1>Welcome to the SCP Foundation</h1>
                <!-- Brief Introduction -->
                <p>
                    The following SCPs documented by the Foundation are classified. 
                    <br>
                    <br>
                    <b>AUTHORISED PERSONNEL ONLY</b>
                    <br>
                    <h4>Select SCP documents above and read below 
                        <br>to learn more about each SCP 
                        <br>and their unique characteristics
                        <br>OR
                        <br><a href="create.php">Create a new SCP record.</a>
                    </h4>
                </p>
                <!-- Display Selected SCP Content -->
                <div>
                    <?php 
                        if (isset($_GET['link'])) 
                        {
                            $item = $_GET['link'];
                            // Prepared statement
                            $stmt = $connection->prepare("select * from scp where item = ?");
                            if(!$stmt)
                            {
                                echo "<p>Error in preparing SQL statement</p>";
                                exit;
                            }
                            $stmt->bind_param("s", $item);
                            if($stmt->execute())
                            {
                                $result = $stmt->get_result();
                                // Check if a record has been retrieved
                                if($result->num_rows > 0)
                                {
                                    $array = array_map('htmlspecialchars', $result->fetch_assoc());
                                    $update = "update.php?update=" . $array['id'];
                                    $delete = "home.php?delete=" . $array['id'];
                                    echo "
                                        <div>
                                            <h2>Item #:{$array['item']}</h2>
                                            <h4>Object Class:{$array['object_class']}</h4>
                                            <div class='img_align'>
                                                <img src='{$array['image']}' alt='{$array['item']}'>
                                            </div>
                                            <h4>Special Containment Procedures:</h4>
                                            <p>{$array['special_containment_procedure']}</p>
                                            <h4>Description:</h4>
                                            <p>{$array['description']}</p>
                                            <p>
                                                <a href='{$update}'>Update Record</a>
                                                <a href='{$delete}'>Delete Record</a>
                                            </p>
                                        </div>
                                    ";
                                }
                                else
                                {
                                    echo "<p>No record found for item {$array['item']}</p>";
                                }
                            }
                            else
                            {
                                echo "<p>Error executing the statement, {$stmt->error}</p>";
                            }
                        } 
                        else 
                        {
                            echo "";
                        }
                        // Delete Record
                        if(isset($_GET['delete']))
                        {
                            $delID = $_GET['delete'];
                            $delete = $connection->prepare("delete from scp where id=?");
                            $delete->bind_param("i", $delID);
                            
                            if($delete->execute())
                            {
                                echo "<div>Record Deleted...</div>";
                            }
                            else
                            {
                                echo "<div>Error deleting record</div>";
                            }
                        }
                    ?>
                </div>
                <img src="images/LOGO-SCP2.png" class="logobox">
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