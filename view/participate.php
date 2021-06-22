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
    $requiredWords2 = $requiredWordAccess->getRequiredWords($_GET['id']);
    
    $wordList = [];
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Novella - Participation</title>
    <link rel="stylesheet" href="view/style/globalStyle.css">
    <style>
      @import url('https://fonts.googleapis.com/css2?family=Raleway:wght@100;500;900&display=swap');
    </style> 
  </head>
  <body>
    <main>
      <h1><?php echo $competition['theme']?> - Participation</h1>
      <form class="form" action="?action=addNovella&id=<?php echo $competition['id']?>" method="POST">
        <h2 class="form__title">Participation</h2>
        <div class="form__login">
          <input type="text" class="form__login__input" name="title" placeholder="Le titre de votre nouvelle" id="title">
          <input class="form__login__button" type="file" name="file" id="filePicker">
          <p id="fileMessage"></p>
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
          <textarea class="form__login__textarea" id="textArea" name="text"><?php echo $competition['incipit']?> </textarea>
          <input id="submit" class="form__login__submit" type="submit" value="Participer" disabled="true">
        </div>
      </form>
    </main>
  </body>

  <script>
    var wordLock = true;
    var checkTitle = true;
    document.getElementById("title").addEventListener("input", (event) => {
      checkTitle = false
      var theme =  "<?php echo $competition['theme']?>";
      var title = document.getElementById("title");
      if(title.value.toLocaleLowerCase().localeCompare(theme.toLocaleLowerCase()) === 0) {
        title.style.borderColor = "red";
        checkTitle = false;
      }
      else {
        checkTitle = true;
      }

      if(title.value === "") {
        document.getElementById("submit").disabled = true;
      }
      else if(!wordLock && checkTitle) {
        document.getElementById("submit").disabled = false;
      }
      else {
        document.getElementById("submit").disabled = true;
      }
    });

    var conjugationArray= []; 
  </script>
<<<<<<< HEAD

    <?php 
      while($datas = mysqli_fetch_array($requiredWords2)) {
=======
    <?php 
      while($datas = mysqli_fetch_array($requiredWords2)){
>>>>>>> 1c41468dbb75fbb1770f04f55cf49d746d230c15
        $tenses = [
          "infinitive" => array("infinitive-present"),
          "indicative" => array("present", "imperfect", "future", "simple-past", "perfect-tense", "pluperfect", "anterior-past", "anterior-future"),
          "conditional" => array("present", "conditional-past"),
          "subjunctive" => array("present", "imperfect", "subjunctive-past", "subjunctive-pluperfect"),
          "imperative" => array("imperative-present", "imperative-past"),
          "participle" => array("present-participle", "past-participle")
        ];

        //check if infinitive exist, if not we avoid to check each tenses
        $url='https://lordmorgoth.net/APIs/conjugation/conjugate?verb='.$datas[0].'&mode=infinitive&tense=infinitive-present';
        $content = @file($url);
<<<<<<< HEAD
        if($content != false) { ?>
          <script>
            conjugationArray.push([]);
          </script>
          <?php
            foreach(array_keys($tenses) as $mode) {
              foreach($tenses[$mode] as $tense) {
                $url='https://lordmorgoth.net/APIs/conjugation/conjugate?verb='.$datas[0].'&mode='.$mode.'&tense='.$tense;
            
                try {
                  // using file() function to get content
                  $lines_array= @file($url);
                  // turn array into one variable
        
                  if($lines_array != false) {
                    $lines_string=implode('',$lines_array);
                    $json = json_decode($lines_string);
                  }
                }
                catch (Exception $e) {}
                ?>
=======
        if($content != false) {
          ?>
          <script>
             conjugationArray.push([]);
          </script>
          <?php
          foreach(array_keys($tenses) as $mode) {
            foreach($tenses[$mode] as $tense) {
              $url='https://lordmorgoth.net/APIs/conjugation/conjugate?verb='.$datas[0].'&mode='.$mode.'&tense='.$tense;
          
              try {
                // using file() function to get content
                $lines_array= @file($url);
                // turn array into one variable
      
                if($lines_array != false) {
                  $lines_string=implode('',$lines_array);
      
                  $json = json_decode($lines_string);
                }
      
                
              }
              catch (Exception $e) {
              }
              ?>
>>>>>>> 1c41468dbb75fbb1770f04f55cf49d746d230c15
              <script>
              <?php 
                if(isset($json)) {
                  if(!(strcmp($json->error, "Unkown verb.") == 0)) {          
                      foreach($json->conjugation as $conjugation) {
                        ?>conjugationArray[conjugationArray.length-1].push("<?php echo $conjugation->verb ?>"); <?php
                      }
<<<<<<< HEAD
                    }
                  } 
                ?>
              </script> <?php
            }
          }
        } 
      }
    ?>
    
    <script>
      var verbs = [];
      conjugationArray.forEach(verb => (verbs.push(verb[0])));
      var validateWords = [];
      document.getElementById("textArea").addEventListener("input", (event) => {
        validateWords = [];
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
            //check verbs
            if(verbs.includes(child.innerText) && child.style.color !== "green") {
              conjugationArray.forEach(verb => {
                if(verb[0] === child.innerText) {
                  //check if text area contains at least one of the conjugation
                  for(var i=0 ; i < verb.length ; i++) {
                    if(finalString.includes(" "+verb[i]) || finalString.includes(verb[i]+" ")) {
                      child.style.color = "green";
                      validateWords.push(child.innerText);
                      break;
                    }
                  }
                }
              });
            }

            if(validateWords.length === document.getElementsByClassName("requiredWord").length && checkTitle) {
              if(document.getElementById("title").value !== "") {
                document.getElementById("submit").disabled = false;
              }
              wordLock = false;
            }
            else {
              document.getElementById("submit").disabled = true;
              wordLock = true;
            }

          }
        })
      });
      
      var incipit = "<?php echo $competition['incipit'] ?>";
      document.getElementById("textArea").addEventListener("keyup", event => {
        if(document.getElementById("textArea").value.length <= incipit.length) {
          document.getElementById("textArea").value = incipit;
        }
      });

      var filePicker = document.getElementById("filePicker");
      filePicker.addEventListener("change", (event) => {
        if(filePicker.files[0].name.split('.').pop() === "txt" ) {
          var reader = new FileReader();
          var res;
          reader.addEventListener('load', (event) => {
            if(event.target.result.substr(0,incipit.length).toLowerCase() === incipit.toLowerCase()) {
              document.getElementById("textArea").value = event.target.result;
            }
            else {
              document.getElementById("fileMessage").innerText = filePicker.files[0].name + ' ne commence pas par l\'incipit "' + incipit + '".';
              document.getElementById("fileMessage").style.color = "red";
            }
            
            triggerEvent(document.getElementById("textArea"), 'input');
          });
          reader.readAsText(filePicker.files[0])
        }
      });


      function triggerEvent(el, type) {
        if ('createEvent' in document) {
            var e = document.createEvent('HTMLEvents');
            e.initEvent(type, false, true);
            el.dispatchEvent(e);
        } else {
            var e = document.createEventObject();
            e.eventType = type;
            el.fireEvent('on' + e.eventType, e);
        }
      }
    </script>
=======
                  }
                } 
              ?></script> <?php
            }
            
          }
        }   
    }
    ?>
    <script>
    var verbs = [];
    conjugationArray.forEach(verb => (verbs.push(verb[0])));
    var validateWords = [];
    document.getElementById("textArea").addEventListener("input", (event) => {
      validateWords = [];
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
          //check verbs
          if(verbs.includes(child.innerText) && child.style.color !== "green") {
            conjugationArray.forEach(verb => {
              if(verb[0] === child.innerText) {
                //check if text area contains at least one of the conjugation
                for(var i=0 ; i < verb.length ; i++) {
                  if(finalString.includes(" "+verb[i]) || finalString.includes(verb[i]+" ")) {
                    child.style.color = "green";
                    validateWords.push(child.innerText);
                    break;
                  }
                }
              }
            });
          }

          if(validateWords.length === document.getElementsByClassName("requiredWord").length && checkTitle) {
            if(document.getElementById("title").value !== "") {
              document.getElementById("submit").disabled = false;
            }
            wordLock = false;
          }
          else {
            document.getElementById("submit").disabled = true;
            wordLock = true;
          }

        }
      })
    });
    
    var incipit = "<?php echo $competition['incipit'] ?>";
    document.getElementById("textArea").addEventListener("keyup", event => {
      if(document.getElementById("textArea").value.length <= incipit.length) {
        document.getElementById("textArea").value = incipit;
        
      }
    });

    var filePicker = document.getElementById("filePicker");
    filePicker.addEventListener("change", (event) => {
      if(filePicker.files[0].name.split('.').pop() === "txt" ) {
        var reader = new FileReader();
        var res;
        reader.addEventListener('load', (event) => {
          if(event.target.result.substr(0,incipit.length).toLowerCase() === incipit.toLowerCase()) {
            document.getElementById("textArea").value = event.target.result;
          }
          else {
            document.getElementById("fileMessage").innerText = filePicker.files[0].name + ' ne commence pas par l\'incipit "' + incipit + '".';
            document.getElementById("fileMessage").style.color = "red";
          }
          
          triggerEvent(document.getElementById("textArea"), 'input');
        });
        reader.readAsText(filePicker.files[0])
      }
    });


    function triggerEvent(el, type) {
      if ('createEvent' in document) {
          var e = document.createEvent('HTMLEvents');
          e.initEvent(type, false, true);
          el.dispatchEvent(e);
      } else {
          var e = document.createEventObject();
          e.eventType = type;
          el.fireEvent('on' + e.eventType, e);
      }
    }
    

    
  </script>
>>>>>>> 1c41468dbb75fbb1770f04f55cf49d746d230c15
</html>