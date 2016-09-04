<?= $success ?? '' ?>
<?= $error ?? '' ?>
<form action="" method="post">
    <input type="text" name="username" required placeholder="<?= Lang::get()->placeholders->username ?>" /><br />
    <input type="email" name="email" required placeholder="<?= Lang::get()->placeholders->email ?>" /><br />
    <input type="password" name="password" required placeholder="<?= Lang::get()->placeholders->password ?>" /><br />
    <input type="submit" value="<?= Lang::get()->register ?>" />
</form>