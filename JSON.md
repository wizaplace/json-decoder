# How to decode json

 Do not use `json_decode()`, before PHP 7.3 you have to manually throw exception when decode fail.

 ## Create a JsonDecoder

 You should create a class for each json you need to decode, who extends `Wizacha\Json\Decoder\AbstractJsonDecoder`.

 Your class should configure AbstractJsonDecoder:
```php
class FooJsonDecoder extends AbstractJsonDecoder
{
    public function __construct()
    {
        $this
            // throw a Wizacha\Json\Exception\JsonDecodeNullException exception if json_decode() return null
            ->setAllowNull(true)
            // transform objects into associative arrays, 2nd parameter of json_decode()
            ->setAssociative(false)
            // depth, 3nd parameter of json_decode()
            ->setDepth(512)
            // transform bigint as string
            ->setBigIntAsString(false)
            // transform objects as arrays, useless if setAssociative(true)
            ->setObjectAsArray(false);
    }
    
    protected function configureDecodedJson(OptionsResolver $optionsResolver): parent
    {
        // if json_decode() return an array, configure expected keys
        // @see https://symfony.com/doc/current/components/options_resolver.html
        
        $optionsResolver
            ->setRequired('myKey')
            ->setAllowedTypes('myKey', 'string');
        
        return $this;
    }
}
```

 ## Use your JsonDecoder to decode json

 If your JsonDecoder don't need dependencies, you could instanciate it manually:
```php
$decodedJson = (new FooJsonDecoder())->decode($json);
```

 If it need dependencies, register it as Symfony service and use it:
```php
$decodedJson = container()->get('json_decoder.foo')->decode($json);
```