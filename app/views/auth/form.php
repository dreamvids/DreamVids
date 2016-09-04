<h1>Welcome to <?= NAME ?> Authenticator</h1>
<?php
if (isset($bad_token)):
    echo Lang::get()->errors->bad_token;
    exit();
endif;
if (isset($error)):
    echo $error;
else:
    if (POST):
        echo '<script>window.open("'.$redirect.'?dvssid='.\Model\Session::getSession().'");window.close();</script>';
        exit();
    endif;
endif;
?>
<form action="" method="post">
    <input type="text" name="username" placeholder="<?= Lang::get()->placeholders->username ?>" required />
    <input type="password" name="password" placeholder="<?= Lang::get()->placeholders->password ?>" required />
    <input type="submit" value="<?= Lang::get()->login ?>" />
</form>