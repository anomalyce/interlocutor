# Interlocutor
A HTTP wrapper that helps with keeping your API integrations structured.

## Setup
We need to create an Interlocutor object somewhere in our application, this may typically be inside of a service provider (or wherever else makes sense in your project). The Interlocutor object expects an [`\Anomalyce\Interlocutor\Contracts\Engine`](src/Contracts/Engine.php) object for the underlying HTTP client - by default, this is [Guzzle](https://github.com/guzzle/guzzle).

```php
$interlocutor = new \Anomalyce\Interlocutor\Interlocutor(
  new \Anomalyce\Interlocutor\Engines\GuzzleHttp
);
```

## Endpoints
For every single API endpoint you intend to interact with, you'll create a class that implements the [`\Anomalyce\Interlocutor\Contracts\Endpoint`](src/Contracts/Endpoint.php) interface.

You may find an example endpoint class for the [Free IP Api](https://freeipapi.com) in the [examples directory](examples/FreeIpApi.php), but in short, you need to define the following methods:

+ `public function method(): \Anomalyce\Interlocutor\Contracts\HttpVerb;`
+ `public function url(string $baseUrl = null): string;`
+ `public function data(array $data = []): array;`
+ `public function headers(array $headers = []): array;`
+ `public function throughDriver(): ?\Anomalyce\Interlocutor\Contracts\Driver;`
+ `public function interjectRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\RequestInterface;`
+ `public function transformResponse(mixed $response): mixed;`
+ `public function handleExceptions(\Throwable $exception): mixed;`

Optionally you may pass in any required user data into the endpoint's constructor, as the Interlocutor isn't relying on it.

### Drivers
In case you're working with a collection of endpoints, it is advisable to define a driver object implementing the [`\Anomalyce\Interlocutor\Contracts\Driver`](src/Contracts/Driver.php) interface. This allows you to manipulate the request/response, specify common headers/data and handle exceptions on a global scale for every endpoint that returns an object of this driver in their `throughDriver()` method.

+ `public function configuration(array $options = []): void;`
+ `public function baseUrl(): string;`
+ `public function data(): array;`
+ `public function headers(): array;`
+ `public function interjectRequest(\Psr\Http\Message\RequestInterface $request): \Psr\Http\Message\RequestInterface;`
+ `public function transformResponse(mixed $response): mixed;`
+ `public function handleExceptions(Throwable $exception): mixed;`

The values of `baseUrl()`, `data()` and `headers()` are passed down to each individual endpoint class' relative methods.

Additionally, should you not want to hardcode the API credentials (or whatever other options you may need), you may utilise the `configure()` method on the Interlocutor object to pass in external data to a driver.

```php
Interlocutor::configure(\Examples\WHMCS\Driver::class, [
  'url'         => 'https://whmcs/includes/api.php',
  'identifier'  => 'your-whmcs-api-identifier-here',
  'secret'      => 'your-whmcs-api-secret-here',
]);
```

## Usage
We have two options when it comes to actually sending the request, either way, we need to instantiate the endpoint...

```php
$request = new \Examples\FreeIpApi($_SERVER['REMOTE_ADDR']);
```

+ **Option A)**
  We pass the endpoint object directly into the Interlocutor's send method.

  ```php
  $response = $interlocutor->send($request);

  print_r($response);
  ```

+ **Option B)**
  We utilise the `\Anomalyce\Interlocutor\Interlocutory` trait on the endpoint class itself, which makes a `send` method available directly on the endpoint object.

  ```php
  // class FreeIpApi implements \Anomalyce\Interlocutor\Contracts\Endpoint {
  //   use \Anomalyce\Interlocutor\Interlocutory;
  // }

  $response = $request->send();

  print_r($response);
  ```

```json
{
  "ipVersion": "4",
  "ipAddress": "140.82.121.4",
  "latitude": "37.7757",
  "longitude": "-122.395203",
  "countryName": "United States of America",
  "countryCode": "US",
  "timeZone": "-08:00",
  "zipCode": "94107",
  "cityName": "San Francisco",
  "regionName": "California",
}
```
