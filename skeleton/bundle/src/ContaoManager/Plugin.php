<?= "<?php" ?>

namespace <?= $this->vendor ?>\<?= $this->namespace ?>\ContaoManager;

use Contao\ManagerPlugin\Bundle\Config\BundleConfig;
use Contao\ManagerPlugin\Bundle\BundlePluginInterface;
use Contao\ManagerPlugin\Routing\RoutingPluginInterface;
use Contao\ManagerPlugin\Bundle\Parser\ParserInterface;
use Contao\CoreBundle\ContaoCoreBundle;
use <?= $this->vendor ?>\<?= $this->namespace ?>\Contao<?= $this->name ?>Bundle;
use Symfony\Component\Config\Loader\LoaderResolverInterface;
use Symfony\Component\HttpKernel\KernelInterface;

class Plugin implements BundlePluginInterface, RoutingPluginInterface
{

    // dies hier ist obligatorisch
    public function getBundles(ParserInterface $parser)
    {
        return [
            BundleConfig::create(Contao<?= $this->name ?>Bundle::class)
                ->setLoadAfter(
                    [ContaoCoreBundle::class]
                )
        ];
    }

    // dies hier wird nur benötigt, wenn eigene Routen außerhalb von Contao benötigt
    // werden, z.B. für eine eigene API (ließe sich aber auch mit Modulen oder Inhalts-
    // elementen lösen) oder Ajax-Requests
    public function getRouteCollection(LoaderResolverInterface $resolver, KernelInterface $kernel)
    {
        return $resolver
            ->resolve(__DIR__ . '/../../config/routing.yml')
            ->load(__DIR__ . '/../../config/routing.yml');
    }
}
