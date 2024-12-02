                    <div class="container mt-3">
                        <h2>Create a Database</h2>
                        <div class="card">
                            <div class="card-body">

                                <?php
                                // Check if $conn is defined and available
                                if (isset($conn)) {
                                    // Database name
                                    $dbname = "myDBPDO";

                                    // SQL query to create the database if it doesn't exist
                                    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";

                                    try {
                                        // Execute the query
                                        $conn->exec($sql);

                                        // Check if the database was created or if it already existed
                                        if ($conn->query("USE $dbname")) {
                                            echo '<p>Database already exists.</p>';
                                        } else {
                                            echo '<p>Database created successfully.</p>';
                                        }
                                    } catch (PDOException $e) {
                                        echo '<p>Error creating database: ' . $e->getMessage() . '</p>';
                                    }

                                    // Close the connection (optional, PDO will handle it)
                                    $conn = null;
                                } else {
                                    echo '<p>Database connection not established.</p>';
                                }
                                ?>
                            </div>
                        </div>
                    </div>