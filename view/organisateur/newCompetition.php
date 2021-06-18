<html>
<head>
  <title>Ajouter un concour</title>
</head>
<body>
  <div class="main">
      <h1 id="title">Ajouter un concour</h1>
    
      <form action="?action=addCompetition" method="POST">
        <input type="text" name="theme" placeholder="theme"/><br />
        <input type="text" name="incipit" placeholder="incipit" /><br />
        <input type="date" name="deadline" placeholder="deadline" /><br />
        <input type="submit"  class="submit" value="Ajouter" />
      </form>
  </div>
  
</body>
</html>