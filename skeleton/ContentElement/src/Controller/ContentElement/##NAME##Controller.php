<?= "<?php" ?>

namespace <?= $this->vendor ?>\<?= $this->namespace ?>\Controller\ContentElement;

use Contao\ContentModel;
use Contao\CoreBundle\Controller\ContentElement\AbstractContentElementController;
use Contao\CoreBundle\DependencyInjection\Attribute\AsContentElement;
use Contao\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

#[AsContentElement(category: '<?= $this->category ?>')]
class <?= $this->name ?>Controller extends AbstractContentElementController
{
    protected function getResponse(Template $template, ContentModel $model, Request $request): Response
    {
        $template->text = $model->text;
        
        return $template->getResponse();
    }
}