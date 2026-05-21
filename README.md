# OpenDXP Elasticsearch Client

This bundle provides a central configuration and factory feature for creating elasticsearch clients to be used in 
other bundles. 

It allows to configure one or more elasticsearch clients with different configuration settings. The corresponding 
settings are then registered as services and can be injected into any services. 

Supported elasticsearch version: Elasticsearch 8

***

## Disclaimer

> OpenDXP is a community-driven fork based on the Pimcore® Community Edition (GPLv3).  
> OpenDXP is independent and maintained by its community and contributors.
> It is not affiliated with, endorsed by, or sponsored by Pimcore GmbH.   
> Original credits: [Pimcore GmbH](https://www.pimcore.com)

**OpenDXP Elasticsearch Client Bundle is based on the Pimcore® Community Edition and remains licensed under GPLv3.**

***

## Installation

Install bundle via composer
```bash
composer require open-dxp/elasticsearch-client-bundle
```

This bundle is a standard symfony bundle. If not required and activated by another bundle, it can be enabled by 
adding it to the `bundles.php` of your application. 


## Configuration

The Configuration takes place in symfony configuration tree where multiple elasticsearch clients can be configured as follows. 
It is possible to configure one or more clients if necessary. 
By default, a `default` client with host set to `localhost:9200` is available and can be customized. 


For details on the configuration opens have a look at inline documentation via command 
`bin/console config:dump-reference OpenDxpElasticsearchClientBundle`

Also see the [Elasticsearch Docs](https://www.elastic.co/guide/en/elasticsearch/client/php-api/current/connecting.html) for 
more information.

```yaml
opendxp_elasticsearch_client:
    es_clients:
        default:
            hosts: ['elastic:9200']
            username: 'elastic'
            password: 'somethingsecret'
            logger_channel: 'opendxp.elasicsearch'
        statistics:
            hosts: ['statistics-node:9200']
            logger_channel: 'opendxp.statistics'
            
            #optional options
            ca_bundle: 'path/to/ca/cert'
            ssl_key: 'path/to/ssl/key'
            ssl_cert: 'path/to/ssl/cert'
            ssl_password: 'secretePW'
            ssl_verification: false #true is the default value
            http_options:
                proxy: 'http://localhost:8125'
            cloud_id: '123456789'
            api_key: 'secret-apikey'
        cloud:
            cloud_id: '123456789'
            api_key: 'secret-apikey'
```

## Integration into other Bundles

For each of the configured clients, a client service is registered in the symfony container. The naming schema follows 
`opendxp.elasticsearch_client.<CLIENT_CONFIGURATION_NAME>`. These client services can be injected into and used by other
services then. 


***

## Upstream Origin & Version Transparency
This project is a fork of the [Pimcore elasticsearch-client (312f317 / v1.1.0)](https://github.com/pimcore/elasticsearch-client/tree/312f31746aec6051941f9ef1913cb30d30b4ea07), which is © Pimcore GmbH and licensed under GPLv3.

## License
Licensed under the GNU General Public License v3.0 (GPLv3). For details, please see [LICENSE.md](LICENSE.md).

## Copyright
© Pimcore GmbH  
© 2026 OpenDXP Contributors — GPLv3

## Trademarks
Pimcore® is a registered [trademark](https://www.trademarkelite.com/europe/trademark/trademark-detail/009309841/PIMCORE) of Pimcore GmbH.
Any use of the Pimcore® mark in this repository is purely descriptive to identify the original upstream project.

***

## Contact
For inquiries, suggestions, or contributions, feel free to reach us at contact@opendxp.io.

## About
OpenDXP is a community-driven project initiated by [DACHCOM.DIGITAL](https://www.dachcom.com/de-ch) (Rheineck, Switzerland) and maintained by its community and contributors.
OpenDXP is independent and not affiliated with Pimcore GmbH.

The project’s purpose is to preserve and maintain a GPLv3‑licensed codebase for community use.

It is **not positioned as a competitor** to products or services of Pimcore GmbH and does **not** purport to replace or supersede any Pimcore offering.   
