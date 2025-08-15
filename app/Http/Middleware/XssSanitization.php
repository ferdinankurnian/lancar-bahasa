<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class XssSanitization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = array_filter($request->all());

        $html_event_attributes = array('onload', 'onunload', 'onclick', 'ondblclick', 'onmousedown', 'onmouseup', 'onmouseover', 'onmousemove', 'onmouseout', 'onkeypress', 'onkeydown', 'onkeyup', 'onfocus', 'onblur', 'onsubmit', 'onreset', 'onchange', 'onselect', 'oninput', 'oncontextmenu');

        array_walk_recursive($input, function (&$input) use ($html_event_attributes) {
            $input = strip_tags(str_replace(array("&lt;", "&gt;"), '', $input), '<span><p><a><b><i><u><strong><br><hr><table><tr><th><td><ul><ol><li><h1><h2><h3><h4><h5><h6><del><ins><sup><sub><pre><address><img><figure><embed><iframe><video><style>');

            foreach ($html_event_attributes as $attribute) {
                $pattern = '/(' . $attribute . '\s*=\s*["\'][^"\']*["\'])/i';
                $input = preg_replace($pattern, '', $input);
            }
        });

        $request->merge($input);
        return $next($request);
    }
}
