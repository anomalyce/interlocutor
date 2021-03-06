<?php

namespace Anomalyce\Interlocutor\Contracts;

enum HttpVerb
{
  case GET;
  case HEAD;
  case POST;
  case PUT;
  case DELETE;
  case CONNECT;
  case OPTIONS;
  case TRACE;
  case PATCH;
}
