<html>
 <head>
 <Title>Registration Form</Title>
 <style type="text/css">
 	body { background-color: #055186;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; border-collapse: collapse}
 	th { font-size: 0.8em; text-align: left; border: none; padding-left: 0; }
 	td { padding: 0.2em; border: 0 none; }
    .table-container th { padding: 0.8em; border-bottom: 1px solid #ccc}
    .table-container td { font-size: 0.8em; padding: 0.8em; border-bottom: 1px solid #ccc}
    span {font-size: 0.8em;}
    input[type="text"],
    input[type="email"],
    input[type="tel"],
    textarea {
        padding: 8px;
        font-size: 14px;
        border: 1px solid #d7dbe8;
        border-radius: 4px;
        width: 100% !important;
        margin-bottom: 8px !important;
    }
    textarea{
        resize: none;
        height: 150px;
    }
    input[type="submit"] {
        background: #ffd200;
        border-radius: 100px;
        padding: 12px 16px 12px 16px !important;
        font-size: 12px !important;
        color: #055186 !important;
        outline: none !important;
        border: none !important;
        min-width: 150px !important;
        text-transform: uppercase;
        cursor: pointer;
        display: inline-block !important;
        text-align: center;
    }
    .container {
        width: 900px;
        height: 80%;
        position: relative;
        background: #fff;
        border-radius: 8px;
        padding: 10px 30px 10px 30px;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        -webkit-transform: translate(-50%, -50%);
    }
    .form-container, .table-container {
        float: left;
    }
    .form-container {
        width: 36%;
        margin-right: 30px;
    }   
    .table-container{ 
        width: 60%;
        height: 100%;
        overflow-x: scroll;
        overflow-y: scroll;
    }
 </style>
 </head>
 <body>
 <div class='container'>
    <div class='form-container'>
        <h1>Register here!</h1>
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