<?php

namespace CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;

/**
 * Class UtilsTrait
 *
 * @package CuteNinja\ParabolaBundle\Tests\Feature\Context\Traits
 */
trait UtilsTrait
{
    /**
     * Returns HttpKernel instance.
     *
     * @return KernelInterface
     */
    public function getKernel()
    {
        return $this->kernelSymfony;
    }

    /**
     * Sets Kernel instance.
     *
     * @param KernelInterface $kernelSymfony
     */
    public function setKernel(KernelInterface $kernelSymfony)
    {
        $this->kernelSymfony = $kernelSymfony;
    }

    /**
     * Returns HttpKernel service container.
     *
     * @return ContainerInterface
     */
    public function getContainer()
    {
        return $this->kernelSymfony->getContainer();
    }

    /**
     * @return TokenStorage
     */
    public function getSecurityContext()
    {
        return $this->getContainer()->get('security.token_storage');
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->getContainer()->get('doctrine')->getManager();
    }

    /**
     * @param string $entityName The name of the entity.
     *
     * @return \Doctrine\ORM\EntityRepository
     */
    protected function getRepository($entityName)
    {
        return $this->getEntityManager()->getRepository($entityName);
    }
}