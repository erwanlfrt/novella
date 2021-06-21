<html>
  <head>
    <title>Novella</title>
  </head>
  <body>
    <form method="post" action="?action=updateUser&update" style="display: flex; flex-direction: column; align-items : flex-start;">
      <input type="text" name="name" value="<?php echo $_SESSION['name'] ?>"/>
      <input type="text" name="firstname" value="<?php echo $_SESSION['firstname'] ?>" />
      <input type="password" name="password" placeholder="password"/>
      <input type="password" name="confirmPassword" placeholder="confirm password" />
      <input type="submit" name="submit" value="submit">
    </form>
    <form method="post" action="?action=updateUser&delete">
      <input type="submit" name="delete" value="delete"/>
    </form>
  </body>
</html>