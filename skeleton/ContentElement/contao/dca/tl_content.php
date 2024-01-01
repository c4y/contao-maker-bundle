<?php if(!$this->fileExists): ?>
    <?= "<?php" ?>
<?php endif; ?>

$GLOBALS['TL_DCA']['tl_content']['palettes']['<?= $this->scname ?>'] = 
    '{type_legend},type;{text_legend},text'
;