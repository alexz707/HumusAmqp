<?php
/**
 * Copyright (c) 2016. Sascha-Oliver Prolic <saschaprolic@googlemail.com>
 *
 *  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 *  "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 *  LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 *  A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 *  OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 *  SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 *  LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 *  DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 *  THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 *  (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 *  OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 *  This software consists of voluntary contributions made by many individuals
 *  and is licensed under the MIT license.
 */

declare (strict_types=1);

namespace Humus\Amqp\Driver\PhpAmqpLib;

use Assert\Assertion;
use PhpAmqpLib\Connection\AMQPStreamConnection as BaseAMQPStreamConnection;

/**
 * Class StreamConnection
 * @package Humus\Amqp\Driver\PhpAmqpLib
 */
class StreamConnection extends AbstractConnection
{
    /**
     * @inheritdoc
     */
    public function __construct(array $credentials = [])
    {
        Assertion::keyExists($credentials, 'host');
        Assertion::keyExists($credentials, 'port');
        Assertion::keyExists($credentials, 'login');
        Assertion::keyExists($credentials, 'password');

        $readWriteTimeout = $credentials['read_timeout'] ?? $credentials['write_timeout'] ?? 3;
        $connectTimeout = $credentials['connect_timeout'] ?? 3;
        $vhost = $credentials['vhost'] ?? '/';

        $this->connection = new BaseAMQPStreamConnection(
            $credentials['host'],
            $credentials['port'],
            $credentials['login'],
            $credentials['password'],
            $vhost,
            false,
            'AMQPLAIN',
            null,
            'en_US',
            $connectTimeout,
            $readWriteTimeout,
            null,
            false,
            0
        );
    }
}