<?php

namespace App\Api\Repositories;

use RuntimeException;
use Illuminate\Http\JsonResponse;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

abstract class BaseRepository
{
    protected const HTML_PATH = "/usr/share/nginx/html/";
    protected const CORE_PATH = "/etc/nginx/conf.d/";

    /**
     * @return string
     */
    protected function nginxContainer(): string
    {
        $container = env('CLIENT_NGINX_CONTAINER');

        if (empty($container)) {
            throw new RuntimeException('CLIENT_NGINX_CONTAINER is not set in the environment.');
        }

        return $container;
    }

    /**
     * @param string $domain
     * @return string
     */
    protected function htmlPath(string $domain): string
    {
        return self::HTML_PATH . $domain;
    }

    /**
     * @param string $domain
     * @return string
     */
    protected function corePath(string $domain): string
    {
        return self::CORE_PATH . "{$domain}.conf";
    }

    /**
     * @param string $action
     * @return string[]|null
     */
    protected function allowedAction(string $action): ?array
    {
        $container = $this->nginxContainer();

        return match ($action) {
            'start'   => ['docker', 'start', $container],
            'stop'    => ['docker', 'stop', $container],
            'restart' => ['docker', 'restart', $container],
            'reload'  => ['docker', 'exec', $container, 'nginx', '-s', 'reload'],
            default   => null,
        };
    }

    /**
     * @param array $command
     * @return string
     */
    protected function runCommand(array $command): string
    {
        $process = new Process($command);
        $process->setTimeout(10);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return trim($process->getOutput());
    }

    /**
     * @return void
     */
    protected function reloadNginx(): void
    {
        $cmd = $this->allowedAction('reload');
        $this->runCommand($cmd);
    }

    /**
     * @param string $message
     * @param array $data
     * @param int $status
     * @return JsonResponse
     */
    protected function success(string $message, array $data = [], int $status = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data
        ], $status);
    }

    /**
     * @param string $message
     * @param int $status
     * @param array $errors
     * @return JsonResponse
     */
    protected function error(string $message, int $status = 400, array $errors = []): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
            'errors' => $errors
        ], $status);
    }
}
