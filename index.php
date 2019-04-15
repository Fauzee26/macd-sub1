<html>
 <head>
 <Title>MACD- Sub1</Title>
 </head>
 <body>
 <div>
    <div>
        <h1>Fill the form!</h1>
        <p>Fill in details, then click <strong>Submit</strong> to register.</p>
        <form method="post" action="index.php" enctype="multipart/form-data" >
            <table>
                <tr>
                    <td><span>Name</span><br><input type="text" name="name" id="name"/></td><td><span>Job</span><br><input type="text" name="job" id="job"/></td>
                </tr>
                <tr>
                    <td><span>Email</span><br><input type="email" name="email" id="email"/></td><td><span>Phone</span><br><input type="tel" name="phone" id="phone"/></td>
                </tr>
                <tr>
                    <td colspan='2'><span>Address</span><br><textarea name="address" id="address"></textarea></td>
                </tr>
                <tr>
                    <td colspan='2'><br><input type="submit" name="submit" value="Submit" /></td>
                </tr>
            </table>
        </form>
    </div>
    <div class='table-container'>
    <?php
        $host = "dicodingazuredb.database.windows.net";
        $user = "fauzee26";
        $pass = "!backpacker2602";
        $db = "sub1dicodingfauzi";
        try {
            $conn = new PDO("sqlsrv:server = $host; Database = $db", $user, $pass);
            $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
        if (isset($_POST['submit'])) {
            try {
                $name = $_POST['name'];
                $email = $_POST['email'];
                $job = $_POST['job'];
                $phone = $_POST['phone'];
                $address = $_POST['address'];
                $date = date("Y-m-d");
                $conn->exec("INSERT INTO [dbo].[User] (name, email, job, phone, address, date) VALUES ('$name','$email','$job','$phone','$address','$date')");
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
            echo "<h3>Your're registered!</h3>";
        } 
            try {
                $sql_select = "SELECT * FROM [dbo].[User]";
                $stmt = $conn->query($sql_select);
                $registrants = $stmt->fetchAll(); 
                if(count($registrants) > 0) {
                    echo "<h2>Registered user:</h2>";
                    echo "<table>";
                    echo "<tr><th>Name</th>";
                    echo "<th>Email</th>";
                    echo "<th>Job</th>";
                    echo "<th>Phone</th>";
                    echo "<th>Address</th>";
                    echo "<th>Date</th></tr>";
                    foreach($registrants as $registrant) {
                        echo "<tr><td>".$registrant['name']."</td>";
                        echo "<td>".$registrant['email']."</td>";
                        echo "<td>".$registrant['job']."</td>";
                        echo "<td>".$registrant['phone']."</td>";
                        echo "<td>".$registrant['address']."</td>";
                        echo "<td>".$registrant['date']."</td></tr>";
                    }
                    echo "</table>";
                } else {
                    echo "<h3>No one is currently registered.</h3>";
                }
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
        
    ?>
    </div>
    <br style='clear: both'/>
 </div>
 </body>
 </html>
