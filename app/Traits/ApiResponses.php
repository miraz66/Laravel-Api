<?php

namespace App\Traits;

trait ApiResponses
{
  protected function ok($message, $data = [], $code = 200)
  {
    return $this->success($message, $data, $code);
  }

  protected function success($message, $data = [], $code = 200)
  {
    return response()->json(['message' => $message, 'data' => $data, 'status' => $code,]);
  }

  protected function error($errors = [], $statusCode = null)
  {
    if (is_string($errors)) {
      return response()->json([
        'message' => $errors,
        'status' => $statusCode
      ], $statusCode);
    }

    return response()->json([
      'errors' => $errors,
    ]);
  }
}
