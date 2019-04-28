<?php

require_once 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;

// $connectionString = "DefaultEndpointsProtocol=https;AccountName=fauzistorages;AccountKey=u0iy9kBTdEd7bRhsTs1bIa3AQ0y29lf6h/YjLet0eJCrmVBeAVEuiS7ZPDOmrVHz8RkpOHmv41Jfcv5dBcslZA==;EndpointSuffix=core.windows.net";

// // Create blob client.
// $blobClient = BlobRestProxy::createBlobService($connectionString);

//         if (isset($_POST['submit'])) {

//     //         $fileToUpload = strtolower($_FILES["fileToUpload"]["name"]);
//     // $content = fopen($_FILES["fileToUpload"]["tmp_name"], "r");
    
//     // $createContainerOptions = new CreateContainerOptions();
//     // $createContainerOptions->setPublicAccess(PublicAccessType::CONTAINER_AND_BLOBS);

//     // // Set container metadata.
//     // $createContainerOptions->addMetaData("key1", "value1");
//     // $createContainerOptions->addMetaData("key2", "value2");

//     //   $containerName = "my_container";

//     //     // Create container.
//     //     $blobClient->createContainer($containerName, $createContainerOptions);
       
//     //     //Upload blob
//     //     $blobClient->createBlockBlob($containerName, $fileToUpload, $content);

//     // $blobClient->createBlockBlob("my_container", $fileToUpload, $content);
//             }
    ?>
<html>
 <head>
 <Title>MACD-Sub1</Title>
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
            $url = "https://fauzistorages.blob.core.windows.net/mycontainer/";
                    
                    $filename = strtolower($_FILES["fileToUpload"]["name"]);
                    // echo $url.''.$filename;

            try {
                $name = $_POST['nama'];
                $jurusan = $_POST['jurusan'];
                $image = str_replace(' ', '%20', $url.''.$filename);
                // $image = $_POST['$fileToUpload'];
                $conn->exec("INSERT INTO [dbo].[formm] (nama, jurusan, image) VALUES ('$name','$jurusan','$image')");
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
                    echo "<th>image</th>";
                    
                    foreach($registrants as $registrant) {
                        ?>
                        <tr>
                            <td><?php echo ".$registrant['nama']." ?></td>
                            <td><?php echo ".$registrant['jurusan']." ?></td>
                            <td>
                                <form action="computervision.php" method="post">
                                    <input type="hidden" name="url" value="<?php echo .$registrant['image'].?>">
                                    <input type="submit" name="submit" value="Analyze!" class="btn btn-primary">
                                </form>
                            </td>


                        <?php

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
    <div>
        <?php

$connectionString = "DefaultEndpointsProtocol=https;AccountName=fauzistorages;AccountKey=MsWpr23l3UhcBhn4eLQ9m4b6Vk11q5UG8x0pA/NoMtVzBwk/ee75Eny8OY93UZzh3wMqCKZMe/jaG1mCRJfdNQ==";
      $containerName = "mycontainer";

// Create blob client.
$blobClient = BlobRestProxy::createBlobService($connectionString);


        if (isset($_POST['submit'])) {
            
$fileToUpload = strtolower($_FILES["fileToUpload"]["name"]);


  
    // try {

  // Create container.
        // $blobClient->createContainer($containerName, $createContainerOptions);
       
       // $myfile = fopen($fileToUpload, "r") or die("Unable to open file!");
       //  fclose($myfile);

       # Mengunggah file sebagai block blob
// echo "Uploading BlockBlob: ".PHP_EOL;
// echo $fileToUpload;
// echo "<br />";
    
    $content = fopen($_FILES["fileToUpload"]["tmp_name"], "r");
      
        //Upload blob
        $blobClient->createBlockBlob($containerName, $fileToUpload, $content);

// }
//     catch(ServiceException $e){
//         // Handle exception based on error codes and messages.
//         // Error codes and messages are here:
//         // http://msdn.microsoft.com/library/azure/dd179439.aspx
//         $code = $e->getCode();
//         $error_message = $e->getMessage();
//         echo $code.": ".$error_message."<br />";
//     }
//     catch(InvalidArgumentTypeException $e){
//         // Handle exception based on error codes and messages.
//         // Error codes and messages are here:
//         // http://msdn.microsoft.com/library/azure/dd179439.aspx
//         $code = $e->getCode();
//         $error_message = $e->getMessage();
//         echo $code.": ".$error_message."<br />";
//     }
            }
        ?>
    </div>
    <br style='clear: both'/>
 </div>
 </body>
 </html>
