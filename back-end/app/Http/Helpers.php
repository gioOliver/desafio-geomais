<?php

namespace App\Http;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class Helpers
{

    public static function response($successContent = null, $errorContent = null, $status = 200, $headers = []): Application|ResponseFactory|\Illuminate\Foundation\Application|Response
    {

        $content = json_encode([
            'success' => !$errorContent,
            'data' => $successContent,
            'errors' =>  $errorContent ? [$errorContent] : []
        ]);

        return response($content, $status, $headers);
    }
    public static function getAttributeErrors( $errors_array, $translation, $locale = 'pt_BR' ):array
    {
        $errors = __($translation . '.invalid_fields', [], $locale);

        $list = [];

        foreach ($errors_array as $index => $error ) {
            foreach ( $error as $key => $value ) {
                $list[] = $value;
            }
        }

        $errors['fields'] = $list;
        return $errors;
    }

    public static function unmaskRequest(array $request): array
    {
        foreach ( $request as $key => $value ) {
            $request[$key] = in_array($key, self::unmaskFields()) ? self::unmask($value) : $value;
        }
        return $request;
    }

    public static function unmask( $field ): string
    {
        return str_replace(['.', '-', '_', '*', '(', ')', '[', ']', '{', '}', ',', '#', '!', '?', ';', ',', '*', '%', '&', '/', '\\', ' '], '', $field);
    }

    private static function unmaskFields(): array
    {
        return [
            'cpf'
        ];
    }
}
