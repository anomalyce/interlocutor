# Interlocutor
A HTTP wrapper that keeps your API integrations well organised.

```bash
composer require anomalyce/interlocutor
```

<br>

## Concepts
Before we start looking at some code, it is important to understand a few core concepts behind this package...

#### Engines
The Interlocutor package doesn't actually send any HTTP requests on its own, but rather relies on an underlying HTTP client (or engine) to do so. You may easily create an implementation for your favourite HTTP client by making sure it implements the `\Anomalyce\Interlocutor\Contracts\Engine` interface.

By default, the Interlocutor package provides a simple [Guzzle](https://github.com/guzzle/guzzle) engine implementation. While this is provided out-of-the-box, you must manually decide to install the `guzzlehttp/guzzle` Composer package should you intend to use it.

#### Endpoints
The Interlocutor package is built on the idea that every API endpoint that you are intending on interacting with, should have its very own dedicated endpoint class (implementing the `\Anomalyce\Interlocutor\Contracts\Endpoint` interface).

Not only does this give you the benefit of having everything related to that API endpoint in one location, but it also makes it a breeze to use the same request in multiple locations across your application.

In summary, an endpoint class contains all the required information needed to make the request. The HTTP verb, the endpoint URL, the data and the headers it requires. It also allows you to easily make modifications to the request object (as assembled by the engine), transform the response or handle any exceptions that may be thrown.

#### Drivers
If you're working against any sizable API, you're more likely than not interacting with more than just a couple of endpoints, which means that you're all of a sudden repeating a bunch of code for each endpoint...

This is where drivers come into the picture. A driver (implementing the `\Anomalyce\Interlocutor\Contracts\Driver` interface) is basically a way of doing all of the repetitive tasks in one place (e.g. specifying the base URL, setting common headers, API credentials, parsing the response using `json_decode()` etc.).

All of the data specified by an in-use driver gets passed down from its driver method to the respective endpoint method as their argument. The only exception, no pun intended, is the `handleExceptions` method which is endpoint first, driver last. It is then up to the endpoint on how to proceed with this information (merging, overriding or ignoring).

<br>

## Usage
In our examples below, we'll use the provided out-of-the-box engine for Guzzle, and thus must also install the Guzzle HTTP library.

```bash
composer require guzzlehttp/guzzle
```

Next up we need to create our Interlocutor object. This should only have to be done once across your application, for most use cases anyway. Place it wherever it makes sense in your application (e.g. in a service provider).

```php
use Anomalyce\Interlocutor\{ Engines, Interlocutor };

$interlocutor = new Interlocutor(
  new Engines\GuzzleHttp
);
```

That's really all you have to do as far as setup goes. It is now time to create your endpoints and/or drivers, but seeing as that heavily relies on how the API itself looks, I'll simply refer you to our examples and various interfaces listed further down.

Once you've got your endpoint objects all set up, you may go ahead and send the request in two different ways. Either, you pass it to the `$interlocutor` object's `send` method, like so...

```php
$request = new \Example\Vendor\MyEndpoint('passing-data-here');

$response = $interlocutor->send($request);

print_r($response);
```

Or, you can utilise the `\Anomalyce\Interlocutor\Interlocutory` trait within your endpoint classes to have them be self-sending. I'll let you decide whichever way suits you and your application best.

```php
// class MyEndpoint implements \Anomalyce\Interlocutor\Contracts\Endpoint {
//   use \Anomalyce\Interlocutor\Interlocutory;
// }

$request = new \Example\Vendor\MyEndpoint('passing-data-here');

$response = $request->send();

print_r($response);
```

<br>

## References
#### Interfaces
+ [`\Anomalyce\Interlocutor\Contracts\Engine`](src/Contracts/Engine.php)
+ [`\Anomalyce\Interlocutor\Contracts\Endpoints`](src/Contracts/Endpoints.php)
+ [`\Anomalyce\Interlocutor\Contracts\Driver`](src/Contracts/Driver.php)

#### Examples
+ [JsonPlaceholder](examples/JsonPlaceholder)
+ [WHMCS](examples/WHMCS/)
+ [FreeIpApi](examples/FreeIpApi/)
