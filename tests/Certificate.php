<?php
/**
 *    Copyright 2019 Matteo Schiff
 *
 *    Licensed under the Apache License, Version 2.0 (the "License");
 *    you may not use this file except in compliance with the License.
 *    You may obtain a copy of the License at
 *
 *        http://www.apache.org/licenses/LICENSE-2.0
 *
 *    Unless required by applicable law or agreed to in writing, software
 *    distributed under the License is distributed on an "AS IS" BASIS,
 *    WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *    See the License for the specific language governing permissions and
 *    limitations under the License.
 *
 */

class Certificate extends Test
{
    function defaults()
    {
        $this->default[] = Entry::required('host', 'string');
        $this->default[] = Entry::required('port', 'integer');

        $this->default[] = Entry::optional('verify_peer', 'boolean', true);
        $this->default[] = Entry::optional('verify_peer_name', 'boolean', true);
        $this->default[] = Entry::optional('allow_self_signed', 'boolean', false);

        $this->default[] = Entry::optional('timeout', 'integer', 1);
        $this->default[] = Entry::optional('days', 'integer', 0);
    }

    function run()
    {
        $context = stream_context_create(array('ssl' => array(
            'capture_peer_cert' => true,
            'verify_peer' => $this->configuration->verify_peer,
            'verify_peer_name' => $this->configuration->verify_peer_name,
            'allow_self_signed' => $this->configuration->allow_self_signed,
        )));

        // Connect to the host using tls (ssl is insecure, if you need it open an issue)
        // Ignore warnings (connection errors are expected)
        $socket = @stream_socket_client('tls://' . $this->configuration->host . ':' . $this->configuration->port,
            $errno, $errstr,
            $this->configuration->timeout,
            STREAM_CLIENT_CONNECT,
            $context);

        // Error while connecting to host
        if (!$socket) {
            return Constants::RETURN_ERROR;
        }

        // Connected, extract the certificate
        $params = stream_context_get_params($socket);
        $certificate = openssl_x509_parse($params['options']['ssl']['peer_certificate']);

        // For how many days the certificate is still valid
        $time_delta = -1;

        if ($certificate) {
            $time_delta = ($certificate["validTo_time_t"] - time()) / 86400;
        }

        if ($time_delta < $this->configuration->days) {
            return Constants::RETURN_ERROR;
        }

        return Constants::RETURN_OK;
    }
}