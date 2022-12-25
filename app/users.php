<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: login.php");
  }
?>
<?php include_once "header.php"; ?>
<body>
  <div class="wrapper">
    <section class="users">
      <header class="headerFix">
        <div class="content">
          <?php 
            $sql = mysqli_query($conn, "SELECT * FROM accounts_users WHERE id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
              $row = mysqli_fetch_assoc($sql);
            }
          ?>
          <img src="/data/users/avatar/<?php echo $row['avatar']; ?>" alt="">
          <div class="details">
            <span><?php echo $row['name'] ?></span>
            <p><?php echo $row['status']; ?></p>
          </div>
        </div>
      </header>
      <div style="margin-top: 80px;"></div>
      <div class="search">
        <span class="text">Выберите чат для общения</span>
        <input type="text" placeholder="Введите имя для поиска...">
        <button><i class="fas fa-search"></i></button>
      </div>

      <div class="users-list">
  
      </div>
      
    </section>
  </div>

  <script src="javascript/users.js"></script>

</body>
</html>
