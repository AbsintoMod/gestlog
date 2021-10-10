<?php
session_start();
if(empty($_SESSION['id'])){
  $_SESSION['msg'] = "<div class='alert alert-danger'>Área restrita!</div>";
  header("Location:/gestlog/pages/home.php");  
  }
  else{$_SESSION["sessiontime"] = time() - 10000;
      header("Location:/gestlog/pages/tela_bloqueio.php");
  }
?>