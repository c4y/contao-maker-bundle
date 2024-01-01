<?= "<?php" ?>

namespace <?= $this->vendor ?>\<?= $this->namespace ?>;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class Contao<?= $this->name ?>Bundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}