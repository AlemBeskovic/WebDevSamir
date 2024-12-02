            <div class="container mt-3">
              <h2>Last Insert ID</h2>
              <div class="card">
                <div class="card-body">
                  <?php

                  // Check if $conn is defined and available
                  if (isset($conn)) {
                    // Database name
                    $dbname = "myDBPDO";

                    try {
                      // Select the database
                      $conn->exec("USE $dbname");

                      // Try to insert the new record
                      try {
                        $sql = "INSERT INTO MyGuests (firstname, lastname, email)
                    VALUES ('John', 'Doe', 'john@example.com')";

                        // Use exec() because no results are returned
                        $conn->exec($sql);

                        // Get the last inserted ID
                        $last_id = $conn->lastInsertId();
                        echo "<p>New record created successfully. <br>Last inserted ID is: <span style='color:red; font-weight: bold;'>" .  $last_id . '<span></p>';
                      } catch (PDOException $e) {
                        // Handle SQL errors
                        echo "<p>Error inserting record: " . $e->getMessage() . '</p>';
                      }
                    } catch (PDOException $e) {
                      // Handle database selection errors
                      echo "<p>Error selecting database: " . $e->getMessage() . '</p>';
                    }

                    // Close the connection
                    $conn = null;
                  } else {
                    echo "<p>Database connection not established.</p>";
                  }
                  ?>
                </div>
              </div>
            </div>