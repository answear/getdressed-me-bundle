# GetdressedMe Bundle
Getdressed.me integration for Symfony.  

Installation
------------

* install with Composer
```
composer require answear/getdressed-me-bundle
```

`Answear\GetdressedMeBundle\AnswearGetdressedMeBundle::class => ['all' => true],`  
should be added automatically to your `config/bundles.php` file by Symfony Flex.

Configuration
-------------

Below you will find bundle's full configuration:

```yaml
answear_getdressed_me:
    apiUrl: 'https://your-getdressed-me-endpoint'
    token: 'super-secret-bearer-token' # token send as Bearer token authorization header 
    storeId: 'your-store'
    requestTimeout: 0 # time the library will wait for server's response. Use 0 to wait indefinitely
    connectionTimeout: 0 # number of seconds to wait while trying to connect to a server. Use 0 to wait indefinitely
```

When using library without Symfony you need to put your configuration into an
instance of `\Answear\GetdressedMeBundle\Service\ConfigProvider` object.

Usage
------------
Simply create request object containing product's id and pass it to `\Answear\GetdressedMeBundle\Service\GetdressedMeService::getOutfits` to get `\Answear\GetdressedMeBundle\Response\OutfitsResponse` as a result.
```php
$outfitsResponse = $getdressedMeService->getOutfits(new GetOutfits('123'));
```

Final notes
------------

Feel free to open pull requests with new features, improvements or bug fixes. The Answear team will be grateful for any comments.

