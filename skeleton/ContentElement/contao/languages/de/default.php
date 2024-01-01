<?php if(!$this->fileExists): ?>
    <?= "<?php" ?>
<?php endif; ?>

$GLOBALS['TL_LANG']['CTE']['<?= $this->scname ?>'] = [
    'My Content Element', 
    'A Content Element for testing purposes.',
];