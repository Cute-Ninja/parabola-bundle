<?php
namespace CuteNinja\ParabolaBundle\Event\Listener;

use Symfony\Component\HttpKernel\Event\FilterResponseEvent;

/**
 * Class ConvertToHtmlResponse
 *
 * @package CuteNinja\ParabolaBundle\Event\Listener
 */
class ConvertToHtmlResponse
{
    /**
     * @var boolean
     */
    private $wrapApiResponse;

    /**
     * @param boolean $wrapApiResponse
     */
    public function __construct($wrapApiResponse)
    {
        $this->wrapApiResponse = $wrapApiResponse;
    }

    /**
     * @param FilterResponseEvent $event
     */
    public function onKernelResponse(FilterResponseEvent $event)
    {
        if(!$this->wrapApiResponse) {
            return;
        }

        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        // Only send back HTML if the requestor allows it
        if (!$request->headers->has('Accept') || (false === strpos($request->headers->get('Accept'), 'text/html'))) {
            return;
        }

        $response = $event->getResponse();
        switch ($request->getRequestFormat()) {
            case 'json':
                $prettyprint_lang = 'js';
                $content          = json_encode(json_decode($response->getContent()), JSON_PRETTY_PRINT);
                break;

            case 'xml':
                $prettyprint_lang = 'xml';
                $content          = $response->getContent();
                break;

            default:
                return;
        }

        $response->setContent(
            '<html><body>' .
            '<pre class="prettyprint lang-' . $prettyprint_lang . '">' .
            htmlspecialchars($content) .
            '</pre>' .
            '<script src="https://google-code-prettify.googlecode.com/svn/loader/run_prettify.js"></script>' .
            '</body></html>'
        );

        // Set the request type to HTML
        $response->headers->set('Content-Type', 'text/html; charset=UTF-8');
        $request->setRequestFormat('html');

        // Overwrite the original response
        $event->setResponse($response);
    }
}