<?php

namespace CuteNinja\ParabolaBundle\HttpResponse;

use CuteNinja\ParabolaBundle\Form\Error\ApiFormError;
use FOS\RestBundle\View\ViewHandler;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

/**
 * Class ClientErrorResponseBuilder
 *
 * @package CuteNinja\ParabolaBundle\HttpResponse
 */
class ClientErrorResponseBuilder extends AbstractResponseBuilder
{
    /**
     * @return Response
     */
    public function forbidden()
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Response::HTTP_FORBIDDEN));
    }

    /**
     * @return Response
     */
    public function notFound()
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Response::HTTP_NOT_FOUND));
    }

    /**
     * @param string $message
     *
     * @return Response
     */
    public function badRequest($message)
    {
        return $this->getServerErrorResponseBuilder()->exception(new HttpException(Response::HTTP_BAD_REQUEST, $message));
    }

    /**
     * @param FormInterface $form
     *
     * @return JsonResponse
     */
    public function jsonResponseFormError(FormInterface $form)
    {
        $apiFormError = new ApiFormError();

        $data = $apiFormError->getFormErrorsAsFormattedArray($form);

        return new JsonResponse($data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }
}