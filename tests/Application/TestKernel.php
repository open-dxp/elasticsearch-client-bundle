<?php

declare(strict_types=1);

namespace OpenDxp\Bundle\ElasticsearchClientBundle\Tests\Application;

use OpenDxp\Bundle\ElasticsearchClientBundle\OpenDxpElasticsearchClientBundle;
use OpenDxp\HttpKernel\BundleCollection\BundleCollection;
use OpenDxp\TestFoundation\Kernel\TestKernel as Foundation;

final class TestKernel extends Foundation
{
    public function registerBundlesToCollection(BundleCollection $collection): void
    {
        $collection->addBundle(new OpenDxpElasticsearchClientBundle());
    }
}
