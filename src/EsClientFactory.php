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
 * @copyright  Modification Copyright (c) OpenDXP (https://www.opendxp.io)
 * @license    https://www.gnu.org/licenses/gpl-3.0.html  GNU General Public License version 3 (GPLv3)
 */

namespace OpenDxp\Bundle\ElasticsearchClientBundle;

use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Psr\Log\LoggerInterface;

class EsClientFactory
{
    public static function create(LoggerInterface $logger, array $configuration): Client
    {
        $builder = ClientBuilder::create()
            ->setHosts($configuration['hosts'])
            ->setLogger($logger);

        if (isset($configuration['username'], $configuration['password'])) {
            $builder->setBasicAuthentication($configuration['username'], $configuration['password']);
        }

        if (isset($configuration['cloud_id'], $configuration['api_key'])) {
            $builder
                ->setElasticCloudId($configuration['cloud_id'])
                ->setApiKey($configuration['api_key']);
        }

        if (isset($configuration['ca_bundle'])) {
            $builder->setCABundle($configuration['ca_bundle']);
        }

        if (isset($configuration['ssl_key']) && $configuration['ssl_cert']) {
            $builder
                ->setSSLKey($configuration['ssl_key'], $configuration['ssl_password'] ?? null)
                ->setSSLCert($configuration['ssl_cert'], $configuration['ssl_password'] ?? null);
        }

        if (isset($configuration['ssl_verification'])) {
            $builder->setSSLVerification($configuration['ssl_verification']);
        }

        if (isset($configuration['http_options'])) {
            $builder->setHttpClientOptions($configuration['http_options']);
        }

        return $builder->build();
    }
}
