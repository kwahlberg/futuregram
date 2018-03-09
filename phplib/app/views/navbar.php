
  <style>
  ul {
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
  }

  li {
      float: left;
  }

  ri {
      float: right;
      list-style-type: none;
      margin: 0;
      padding: 0;
      overflow: hidden;
      background-color: #333;
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
  }

  li a {
      display: block;
      color: white;
      text-align: center;
      padding: 14px 16px;
      text-decoration: none;
  }

  li a:hover {
      background-color: #111;
  }
  </style>


  <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
  <![endif]-->
</head>

<body>

  <ul id="nav">
    <li><a class="active" href="index.php?page=home">Home</a></li>
    <li><a href="index.php?page=following">Following</a></li>
    <li><a href="index.php?page=settings">Settings</a></li>
    <li><a href="index.php?page=logout">Logout</a></li>
    <li><a href="index.php?page=profile">Profile</a></li>
  <ri><?php echo $_SESSION['username']?></ri>

  </ul>

  <script src="js/scripts.js"></script>
</body>
</html>
