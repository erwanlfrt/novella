<?php

if (!$_SESSION['admin']) {
  header("Location: /?action=home");
}

?>

<html>

<head>
  <title>Ajouter un concour</title>
</head>

<body>
  <div class="main">
    <h1 id="title">Ajouter un concour</h1>

    <input type="text" id="requiredWords" name="requiredWords" /><button onclick="addWord()">Ajouter des mots</button>
    <div id="error"></div>
    <div id="words"></div>

    <form id="form" name="form" action="?action=addCompetition" method="POST">
      <input type="text" name="theme" placeholder="theme" /><br />
      <input type="text" name="incipit" placeholder="incipit" /><br />
      <input type="date" name="deadline" placeholder="deadline" /><br />
      <input type="hidden" name="requiredWords" id="requiredWords" value="">
      <input type="submit" class="submit" value="Ajouter le concour" />
    </form>


  </div>
</body>

<script>
  let arrayOfWord = [];
  let inputElement = document.getElementById('requiredWords');
  let errorElement = document.getElementById('error');
  let wordsElement = document.getElementById('words');

  function addWord() {
    let word = inputElement.value;
    if (word.trim() === "") {
      errorElement.innerHTML = "Empty input";
    } else {
      console.log(arrayOfWord);
      arrayOfWord.push(word);
      document.form.requiredWords.value = arrayOfWord;
      words.innerHTML = arrayOfWord.join(' - ');
    }
    inputElement.value = "";
  }
</script>

</html>