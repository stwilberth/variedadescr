<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CompressResponse
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        // Verificar si la compresión está habilitada en el servidor
        if (!ini_get('zlib.output_compression') && 
            strpos($request->header('Accept-Encoding'), 'gzip') !== false) {

            // Tipos de contenido que queremos comprimir
            $compressibleTypes = [
                'text/html',
                'text/plain',
                'text/css',
                'text/javascript',
                'application/javascript',
                'application/x-javascript',
                'application/json',
                'application/xml',
                'application/x-httpd-php',
            ];

            $contentType = $response->headers->get('Content-Type');
            if ($contentType) {
                $contentType = strtolower(preg_replace('/\s*;.*$/', '', $contentType));
                
                if (in_array($contentType, $compressibleTypes)) {
                    $content = $response->getContent();
                    if (strlen($content) > 1024) { // Comprimir solo si es mayor a 1KB
                        $compressed = gzencode($content, 9);
                        
                        if ($compressed !== false) {
                            $response->setContent($compressed);
                            $response->headers->add([
                                'Content-Encoding' => 'gzip',
                                'X-Compression' => 'gzip',
                                'Content-Length' => strlen($compressed),
                                'Vary' => 'Accept-Encoding'
                            ]);
                        }
                    }
                }
            }
        }

        return $response;
    }
}
