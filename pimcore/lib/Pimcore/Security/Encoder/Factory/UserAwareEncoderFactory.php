<?php
/**
 * Pimcore
 *
 * This source file is available under two different licenses:
 * - GNU General Public License version 3 (GPLv3)
 * - Pimcore Enterprise License (PEL)
 * Full copyright and license information is available in
 * LICENSE.md which is distributed with this source code.
 *
 * @copyright  Copyright (c) Pimcore GmbH (http://www.pimcore.org)
 * @license    http://www.pimcore.org/license     GPLv3 and PEL
 */

namespace Pimcore\Security\Encoder\Factory;

use Pimcore\Security\Encoder\UserAwarePasswordEncoderInterface;
use Pimcore\Security\Exception\ConfigurationException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class UserAwareEncoderFactory extends AbstractEncoderFactory
{
    /**
     * @var EncoderInterface[]
     */
    private $encoders = [];

    /**
     * @inheritDoc
     */
    public function getEncoder($user)
    {
        if (!$user instanceof UserInterface) {
            throw new \RuntimeException(sprintf(
                'Need an instance of UserInterface to build an encoder, "%s" given',
                is_object($user) ? get_class($user) : gettype($user)
            ));
        }

        if (isset($this->encoders[$user->getUsername()])) {
            return $this->encoders[$user->getUsername()];
        }

        $reflector = $this->getReflector();
        if (!$reflector->implementsInterface(UserAwarePasswordEncoderInterface::class)) {
            throw new ConfigurationException('An encoder built by the UserAwareEncoderFactory must implement UserAwareEncoderInterface');
        }

        /** @var UserAwarePasswordEncoderInterface $encoder */
        $encoder = $this->buildEncoder($reflector);
        $encoder->setUser($user);

        $this->encoders[$user->getUsername()] = $encoder;

        return $encoder;
    }
}