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
                    <td><span>jurusan</span><br><input type="text" name="jurusan" id="jurusan"/></td>
                </tr>
             
                <div class="mt-4 mb-2">
            <form class="d-flex justify-content-lefr" action="index.php" method="post" enctype="multipart/form-data">
                <input type="file" name="fileToUpload" accept=".jpeg,.jpg,.png" required="">
            </form>
        </div>
                <tr>
                    <td colspan='2'><br><input type="submit" name="submit" value="Submit" /></td>
                </tr>
            </table>
        </form>
    </div>
    <div class='table-container'>
    <?php

    require_once 'vendor/autoload.php';
require_once "./random_string.php";

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

$connectionString = "DefaultEndpointsProtocol=https;AccountName=fauzistorages;AccountKey=u0iy9kBTdEd7bRhsTs1bIa3AQ0y29lf6h/YjLet0eJCrmVBeAVEuiS7ZPDOmrVHz8RkpOHmv41Jfcv5dBcslZA==;EndpointSuffix=core.windows.net";

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);


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

            $fileToUpload = strtolower($_FILES["fileToUpload"]["name"]);
    $content = fopen($_FILES["fileToUpload"]["tmp_name"], "r");
    
    $createContainerOptions = new CreateContainerOptions();
    $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

    // Set container metadata.
    $createContainerOptions->addMetaData("key1", "value1");
    $createContainerOptions->addMetaData("key2", "value2");

      $containerName = "my_container";

        // Create container.
        $blobClient->createContainer($containerName, $createContainerOptions);

       
        //Upload blob
        $blobClient->createBlockBlob($containerName, $fileToUpload, $content);

    $blobClient->createBlockBlob("my_container", $fileToUpload, $content);
            try {
                $name = $_POST['nama'];
                $jurusan = $_POST['jurusan'];
                $conn->exec("INSERT INTO [dbo].[formm] (nama, jurusan) VALUES ('$name','$jurusan')");
            } catch(Exception $e) {
                echo "Failed: " . $e;
            }
        } 
            try {
                $sql_select = "SELECT * FROM [dbo].[formm]";
                $stmt = $conn->query($sql_select);
                $registrants = $stmt->fetchAll(); 
                if(count($registrants) > 0) {
                    echo "<h2>Registered user:</h2>";
                    echo "<table>";
                    echo "<tr><th>nama</th>";
                    echo "<th>jurusan</th>";
                    foreach($registrants as $registrant) {
                        echo "<tr><td>".$registrant['nama']."</td>";
                        echo "<td>".$registrant['jurusan']."</td>";
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
