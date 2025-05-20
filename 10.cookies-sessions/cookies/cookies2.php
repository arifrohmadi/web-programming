<?php
// set the expiration date to one hour ago
setcookie("user", "", time() - 3600);
?>
<!DOCTYPE html>
<html lang="en">
<body>

<?php
echo "Cookie 'user' is deleted.";
?>

</body>
</html>

