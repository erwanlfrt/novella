<?php

session_status() === PHP_SESSION_ACTIVE ?: session_start();
require_once 'model/tables/competition.php';
require_once 'model/tables/requiredWord.php';
use \model\tables\Competition;
use \model\tables\RequiredWord;

$requiredWordAccess = new RequiredWord;
$dataAccess = new Competition;

if(isset($_GET['id'])) {
  $competition = $dataAccess->getCompetition($_GET['id']);
  $requiredWords = $requiredWordAccess->getRequiredWords($_GET['id']);
  $wordList = [];
}


?>

<html>
  <head>
    <title>Novella</title>
  </head>
  <body>
    <h1>Concours: <?php echo $competition['theme']?></h1>
    <form style="display: flex; flex-direction: column; align-items: flex-start;" action="?action=addNovella&id=<?php echo $competition['id']?>" method="POST">
      <input type="text" name="title" placeholder="titre">
      <input type="file" name="file">
      <div>
      <h3>mots requis: </h3>
      <ul id="wordListView">
      <?php
        while($data = mysqli_fetch_array($requiredWords)){
          ?><li style="color:red" class="requiredWord"><?php echo $data[0]?></li><?php
          array_push($wordList, $data[0]);
         }
        ?>
      </ul>
      </div>
      
      <textarea id="textArea" rows="10" cols="150" name="text" placeholder="<?php echo $competition['incipit']?>..."></textarea>
      <input id="submit" type="submit" value="submit" disabled="true">
    </form>
  </body>
  <script>
    document.getElementById("textArea").addEventListener("input", (event) => {
      var validateWords = [];
      document.getElementById("wordListView").childNodes.forEach(child => {
        var punctuationless = document.getElementById("textArea").value.toLowerCase().replace(/[.,\/#!$%\^&\*;:{}=\-_`~()]/g,"");
        var finalString = punctuationless.replace(/\s{2,}/g," "); 
        if(child.innerText !== undefined) {
          if(finalString.includes((" "+child.innerText.toLowerCase()+" "))) {
          child.style.color = "green";
          validateWords.push(child.innerText);
          }
          else if (finalString.substr(0, finalString.indexOf(" ")).toLowerCase() === child.innerText.toLowerCase()) {
            child.style.color = "green";
            validateWords.push(child.innerText);
          }
          else {
            child.style.color = "red";
          }
        }
        if(validateWords.length === document.getElementsByClassName("requiredWord").length ) {
          document.getElementById("submit").disabled = false;
        }
        else {
          document.getElementById("submit").disabled = true;
        }
      })
    });
  </script>
</html>