<?php

declare(strict_types=1);

namespace App\Http\Responder;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

abstract class BaseResponder implements Responsable
{
    protected const STATUS_CODE = 200;

    public function toResponse($request): JsonResponse
    {
        $result = [
            'status' => true,
            'message' => '',
            'errors' => null,
            'data' => null,
        ];

        $result['data'] = $this->object_to_array($this) ?: null;
        return new JsonResponse($result, static::STATUS_CODE);
    }

    protected function object_to_array($data, bool $strict = true)
    {
        if (true === \is_object($data)) {
            if (method_exists($data, '__toArray')) {
                return $data->__toArray($strict);
            }

            if (method_exists($data, '__toString')) {
                return $data->__toString();
            }

            $array = [];
            foreach ((array) $data as $key => $value) {
                $key = preg_replace('/\000(.*)\000/', '', $key);
                $array[$key] = $this->object_to_array($value, $strict);
            }

            return $array;
        }

        if (true === \is_array($data)) {
            $stack = [];
            foreach ($data as $key => $value) {
                $stack[$key] = $this->object_to_array($value, $strict);
            }

            return $stack;
        }

        return $data;
    }
}
