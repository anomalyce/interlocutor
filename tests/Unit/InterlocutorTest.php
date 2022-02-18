<?php

use Anomalyce\Interlocutor\{ Contracts, Engines, Interlocutor, InterlocutorException };

beforeEach(fn () => Interlocutor::setInstance(null));

it('cannot be instantiated without an engine object', function () {
  expect(fn () => new Interlocutor)->toThrow(ArgumentCountError::class);
});

it('expects the first argument to be an engine object', function () {
  expect(fn () => new Interlocutor('testing'))->toThrow(TypeError::class);
});

it('can be instantiated with an engine object', function () {
  $engine = new Engines\GuzzleHttp;
  $interlocutor = new Interlocutor($engine);

  expect($engine)->toBeInstanceOf(Contracts\Engine::class);
  expect($interlocutor)->toBeInstanceOf(Interlocutor::class);
});

it('can get a previously instantiated interlocutor object', function () {
  expect(fn () => Interlocutor::getInstance())->toThrow(InterlocutorException::class);

  $interlocutor = new Interlocutor(new Engines\GuzzleHttp);

  expect(Interlocutor::getInstance())->toBeInstanceOf(Interlocutor::class);
});

it('can unset a previously instantiated interlocutor object', function () {
  $interlocutor = new Interlocutor(new Engines\GuzzleHttp);

  expect(Interlocutor::getInstance())->toBeInstanceOf(Interlocutor::class);

  Interlocutor::setInstance(null);

  expect(fn () => Interlocutor::getInstance())->toThrow(InterlocutorException::class);
});

it('can configure a specific driver', function ($options) {
  $interlocutor = new Interlocutor(new Engines\GuzzleHttp);

  Interlocutor::configure(\Examples\WHMCS\Driver::class, $options);

  expect($interlocutor->getDriverConfiguration(new \Examples\WHMCS\Driver))->toEqual($options);
})->with('drivers');


