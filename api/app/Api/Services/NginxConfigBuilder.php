<?php

namespace App\Api\Services;

class NginxConfigBuilder
{
    /**
     * @param string $domain
     * @return string
     */
    public static function make(string $domain): string
    {
        $config = <<<CONF
        server {
            listen 80;
            server_name {$domain};

            root /usr/share/nginx/html/{$domain};
            index index.html;

            location / {
                try_files \$uri \$uri/ =404;
            }
        }
        CONF;

        return str_replace('$', '\\$', $config);
    }
}
