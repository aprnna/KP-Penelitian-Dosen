<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $title; ?></title>
</head>

<body>
  <h1>User Login: <?php echo htmlspecialchars($user->full_name); ?></h1>
  <form action="<?php echo BASE_URL; ?>auth/logout" method="POST">
    <button type="submit">Logout</button>
  </form>
</body>

</html>