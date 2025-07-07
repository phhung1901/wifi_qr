<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class NoIndexAdminPages
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);
        
        // Check if this is an admin route
        if ($request->is('admin/*') || $request->is('admin')) {
            // Add meta robots noindex, nofollow headers
            $response->headers->set('X-Robots-Tag', 'noindex, nofollow, noarchive, nosnippet, noimageindex');
            
            // If it's an HTML response, we can also inject meta tags
            if ($response->headers->get('content-type') && 
                strpos($response->headers->get('content-type'), 'text/html') !== false) {
                
                $content = $response->getContent();
                
                // Add meta robots tag if <head> exists and meta robots doesn't already exist
                if (strpos($content, '<head>') !== false && 
                    strpos($content, 'name="robots"') === false) {
                    
                    $metaTag = '<meta name="robots" content="noindex, nofollow, noarchive, nosnippet, noimageindex">';
                    $content = str_replace('<head>', '<head>' . "\n    " . $metaTag, $content);
                    $response->setContent($content);
                }
            }
        }
        
        return $response;
    }
}
