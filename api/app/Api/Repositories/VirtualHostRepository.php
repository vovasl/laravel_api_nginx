<?php

namespace App\Api\Repositories;

use App\Api\Repositories\Interfaces\VirtualHostRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;
use App\Api\Services\NginxConfigBuilder;

class VirtualHostRepository extends BaseRepository implements VirtualHostRepositoryInterface
{
    /**
     * @param string $domain
     * @return JsonResponse
     */
    public function createVirtualHost(string $domain): JsonResponse
    {
        try {
            $htmlPath = $this->htmlPath($domain);
            $confPath = $this->corePath($domain);

            $this->runCommand([
                'docker', 'exec', $this->nginxContainer(),
                'bash', '-c',
                "mkdir -p {$htmlPath} && echo 'HELLO {$domain}' > {$htmlPath}/index.html"
            ]);

            $nginxConfig = NginxConfigBuilder::make($domain);
            $this->runCommand([
                'docker', 'exec', '-i', $this->nginxContainer(),
                'bash', '-c',
                "echo \"$nginxConfig\" > {$confPath}"
            ]);

            $this->reloadNginx();

            return $this->success("Virtual host {$domain} created successfully");
        } catch (ProcessFailedException $e) {
            Log::error('Failed to create virtual host', ['domain' => $domain, 'error' => $e->getMessage()]);
            return $this->error("Failed to create virtual host: " . $e->getMessage());
        }
    }

    /**
     * @param string $domain
     * @return JsonResponse
     */
    public function deleteVirtualHost(string $domain): JsonResponse
    {
        try {
            $htmlPath = $this->htmlPath($domain);
            $confPath = $this->corePath($domain);

            $this->runCommand([
                'docker', 'exec', $this->nginxContainer(),
                'bash', '-c',
                "rm -rf {$htmlPath} {$confPath}"
            ]);

            $this->reloadNginx();

            return $this->success("Virtual host {$domain} deleted successfully");
        } catch (ProcessFailedException $e) {
            Log::error('Failed to delete virtual host', ['domain' => $domain, 'error' => $e->getMessage()]);
            return $this->error("Failed to delete virtual host: " . $e->getMessage());
        }
    }
}
