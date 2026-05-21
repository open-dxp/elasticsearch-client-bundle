<?php

/**
 * OpenDXP
 *
 * This source file is licensed under the GNU General Public License version 3 (GPLv3).
 *
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (https://pimcore.com)
 * @copyright  Modification Copyright (c) OpenDXP (https://www.opendxp.ch)
 * @license    https://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License version 3 (GPLv3)
 */

namespace OpenDxp\Bundle\ElasticsearchClientBundle\DependencyInjection;

use Elastic\Elasticsearch\Client;
use OpenDxp\Bundle\ElasticsearchClientBundle\EsClientFactory;
use OpenDxp\Bundle\ElasticsearchClientBundle\SearchClient\SearchClient;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\DependencyInjection\ConfigurableExtension;

class OpenDxpElasticsearchClientExtension extends ConfigurableExtension implements PrependExtensionInterface
{
    const CLIENT_SERVICE_PREFIX = 'opendxp.elasticsearch_client.';

    const OPENDXP_CLIENT_PREFIX = 'opendxp.elasticsearch.custom_client.';

    #[\Override]
    public function getAlias(): string
    {
        return 'opendxp_elasticsearch_client';
    }

    protected function loadInternal(array $mergedConfig, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('services.yaml');

        $definitions = [];

        foreach ($mergedConfig['es_clients'] as $name => $clientConfig) {
            $definition = new Definition(Client::class);
            $definition->setFactory(EsClientFactory::class . '::create');
            $definition->setArgument('$logger', new Reference('logger'));
            $definition->setArgument('$configuration', $clientConfig);
            $definition->addTag('monolog.logger', ['channel' => $clientConfig['logger_channel']]);
            $definitions[self::CLIENT_SERVICE_PREFIX . $name] = $definition;

            $customClientDefinition = new Definition(SearchClient::class);
            $customClientDefinition->setArgument('$client', $definition);
            $definitions[self::OPENDXP_CLIENT_PREFIX . $name] = $customClientDefinition;
        }

        $container->addDefinitions($definitions);
    }

    public function prepend(ContainerBuilder $container)
    {
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../../config'));
        $loader->load('default_config.yaml');
    }
}
