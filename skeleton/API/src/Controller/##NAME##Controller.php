<?= "<?php" ?>

namespace <?= $this->vendor ?>\<?= $this->namespace ?>\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

 #[Route('/example', name: <?= $this->name ?>Controller::class)]
class <?= $this->name ?>Controller extends AbstractController
{

    /**
     * TestController constructor.
     */
    public function __construct()
    {}

    /**
     * @param Request $request
     *
     * @return void
     */
    public function __invoke(Request $request)
    {
		return new Response("TEST");
    }
}