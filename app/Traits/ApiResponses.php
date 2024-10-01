<?php

namespace App\Traits;

trait ApiResponses
{
  protected function ok($message, $data = [])
  {
    return $this->success($message, $data, 200);
  }

  protected function success($message, $data = [], $code = 200)
  {
    return response()->json(['message' => $message, 'data' => $data, 'status' => $code,]);
  }

  protected function error($message, $statusCode = 404)
  {
    return response()->json(['error' => $message], $statusCode);
  }
}
