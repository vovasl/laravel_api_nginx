<?php

namespace App\Api\Repositories;

use App\Api\Repositories\Interfaces\NginxRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Throwable;

class NginxRepository extends BaseRepository implements NginxRepositoryInterface
{
    /**
     * @param string $action
     * @return JsonResponse
     */
    public function performAction(string $action): JsonResponse
    {
        $cmd = $this->allowedAction($action);

        if ($cmd === null) {
            return $this->error('Action not allowed');
        }

        try {
            $output = $this->runCommand($cmd);
            return $this->success("Nginx {$action} successfully", ['output' => $output]);
        } catch (ProcessFailedException $e) {
            Log::error('Nginx command failed', ['action' => $action, 'error' => $e->getMessage()]);
            return $this->error("Failed to {$action} nginx: " . $e->getMessage(), 500);
        } catch (Throwable $e) {
            Log::error('Unexpected error controlling nginx', ['action' => $action, 'error' => $e->getMessage()]);
            return $this->error("Unexpected error: " . $e->getMessage(), 500);
        }
    }
}
