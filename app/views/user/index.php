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
  <h1>User List</h1>

  <?php if (!empty($users)): ?>
    <table border="1">
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($users as $user): ?>
          <tr>
            <td><?php echo $user->id; ?></td>
            <td><?php echo $user->name; ?></td>
            <td><?php echo $user->email; ?></td>
            <td>
              <a href="<?php echo BASE_URL; ?>user/detail/<?php echo $user->id; ?>">View</a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php else: ?>
    <p>No users found.</p>
  <?php endif; ?>
</body>

</html>