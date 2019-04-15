<html>
 <head>
 <Title>MACD- Sub1</Title>
 </head>
 <body>
 <div>
    <div>
        <h1>Fill the form!</h1>
        <form method="post" action="index.php" enctype="multipart/form-data" >
            <table>
                <tr>
                    <td><span>nama</span><br><input type="text" name="nama" id="nama"/></td>
                </tr>
                <tr>
                    <td><span>jurusan</span><br><input type="text" name="jurusan" id="jurusan"/></td><td><span>kota asal</span><br><input type="text" name="kota asal" id="kota"/></td>
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
                $name = $_POST['nama'];
                $jurusan = $_POST['jurusan'];
                $kota = $_POST['kota'];
                $conn->exec("INSERT INTO [dbo].[form] (nama, jurusan, kota) VALUES ('$name','$jurusan','$kota')");
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
            echo "<h3>Your're registered!</h3>";
        } 
            try {
                $sql_select = "SELECT * FROM [dbo].[form]";
                $stmt = $conn->query($sql_select);
                $registrants = $stmt->fetchAll(); 
                if(count($registrants) > 0) {
                    echo "<h2>Registered user:</h2>";
                    echo "<table>";
                    echo "<tr><th>nama</th>";
                    echo "<th>jurusan</th>";
                    echo "<th>kota asal</th>";
                    foreach($registrants as $registrant) {
                        echo "<tr><td>".$registrant['nama']."</td>";
                        echo "<td>".$registrant['jurusan']."</td>";
                        echo "<td>".$registrant['kota']."</td>";
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
