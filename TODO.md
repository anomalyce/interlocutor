# Interlocutor

## Usage
```php
use Anomalyce\Interlocutor\{ Interlocutor, Engines };

$interlocutor = new Interlocutor(new Engines\GuzzleHttp);

$request = new \Examples\FreeIpApi($_SERVER['REMOTE_ADDR']);

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
