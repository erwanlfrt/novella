<html>
<head>
  <title>User Registration</title>
</head>
<body>
  <div class="main">
      <h1 id="title">Register</h1>
    
      <form action="?action=register" method="POST">
        <input type="text" name="email" placeholder="email"/><br />
        <input type="password" name="password" placeholder="password" /><br />
        <input type="password" name="password_confirm" placeholder="confirm password" /><br />
        <input type="name" name="name" placeholder="name" /><br />
        <input tyê="firstname" name="firstname" placeholder="firstname" /><br/>
        <input type="submit"  class="submit" value="Register" />
      </form>
      <div>
        <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1)
                    {
                      echo "<p style='color:red'>Invalid form</p>";
                    }
                    else if($err==2){
                      echo "<p style='color:red'>User already exist</p>";
                    }
                    else if($err==3)
                    {
                      echo "<p style='color:red'>Passwords don't match</p>";
                    }
                    else if($err==4)
                    {
                      echo "<p style='color:red'>wrong login and/or password</p>";
                    }
                }
        ?>
      </div>
  </div>
  
</body>
</html>