<?php

require_once 'vendor/autoload.php';

use MicrosoftAzure\Storage\Blob\BlobRestProxy;
use MicrosoftAzure\Storage\Common\Exceptions\ServiceException;
use MicrosoftAzure\Storage\Blob\Models\ListBlobsOptions;
use MicrosoftAzure\Storage\Blob\Models\CreateContainerOptions;
use MicrosoftAzure\Storage\Blob\Models\PublicAccessType;
?>

<html>
 <head>
 <Title>MACD-Sub1</Title>
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
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
                    echo "<th>action</th>";

                    foreach($registrants as $registrant) {
                        ?>
                        <tr>
                            <td><?php echo "".$registrant['nama']."" ?></td>
                            <td><?php echo "".$registrant['jurusan']."" ?></td>
                            <td><?php echo "".$registrant['image']."" ?></td>
                            <td>
                                <form action="analyzed.php" method="post">
                                    <input type="hidden" name="link" value="<?php echo "".$registrant['image']."" ?>">
                                    <input type="submit" name="analyze" value="Analyze" class="btn btn-primary">

                                </form>
                            </td>
                        </tr>
                        <?php

                    }
$link = = $_POST['link'];
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
    
    $content = fopen($_FILES["fileToUpload"]["tmp_name"], "r");
      
        //Upload blob
        $blobClient->createBlockBlob($containerName, $fileToUpload, $content);

            }

    //         if (isset($_POST['analyze'])) {
    //         processImage();
    // }
        ?>
    </div>
    <br style='clear: both'/>
 </div>

 <!-- <script type="text/javascript">
    function processImage() {
        
        var subscriptionKey = "4b145aca423d417594852790c1d1aa79";
 
        var uriBase =
            "https://southeastasia.api.cognitive.microsoft.com/vision/v2.0/analyze";
 
        // Request parameters.
        var params = {
            "visualFeatures": "Categories,Description,Color",
            "details": "",
            "language": "en",
        };
 
        // Display the image.
        // var sourceImageUrl = "<?php echo $link ?>";
        document.querySelector("#sourceImage").src = sourceImageUrl;
 
        // Make the REST API call.
        $.ajax({
            url: uriBase + "?" + $.param(params),
 
            // Request headers.
            beforeSend: function(xhrObj){
                xhrObj.setRequestHeader("Content-Type","application/json");
                xhrObj.setRequestHeader(
                    "Ocp-Apim-Subscription-Key", subscriptionKey);
            },
 
            type: "POST",
 
            // Request body.
            data: '{"url": ' + '"' + sourceImageUrl + '"}',
        })
 
        .done(function(data) {
            $("#description").text(data.description.captions[0].text);

        })
 
        .fail(function(jqXHR, textStatus, errorThrown) {
            // Display error message.
            var errorString = (errorThrown === "") ? "Error. " :
                errorThrown + " (" + jqXHR.status + "): ";
            errorString += (jqXHR.responseText === "") ? "" :
                jQuery.parseJSON(jqXHR.responseText).message;
            alert(errorString);
        });
    };
</script>

<h1>Analyzed image:</h1>
    <div>
<br><br>
<div id="wrapper" style="width:1020px; display:table;">
    <div id="jsonOutput" style="width:600px; display:table-cell;">
        Response:
        <br><br>
        <textarea id="responseTextArea" class="UIInput"
                  style="width:580px; height:400px;"></textarea>
    </div>
    <div id="imageDiv" style="width:420px; display:table-cell;">
        Source image:
        <br><br>
        <img id="sourceImage" width="400" />
                <h3 id="description"></h3>

    </div>
</div> -->
 </body>
 </html>
