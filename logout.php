<?php
if (isset($_COOKIE['remember'])) :
    setcookie('auth', '', time() - 31556926);
    setcookie('name', '', time() - 31556926);
    setcookie('remember', '', time() - 31556926);
else :
    setcookie('auth', '', time() - 3600);
    setcookie('name', '', time() - 3600);
endif;
header('location: ./');
exit();
