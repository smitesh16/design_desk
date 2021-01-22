Dear <?= $data['Name']; ?>

Verify by clicking on the url below:
<?= Config('emailvalidationurl');?>?code=<?= $data['Code']; ?>
