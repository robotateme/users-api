<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Application\DTOs\UserCleanupDTO;
use Application\UseCases\UsersCleanupUseCase;
use Illuminate\Console\Command;

class CleanupUsersCronCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-users';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(UsersCleanupUseCase $cleanupUseCase): void
    {
        $dto = new UserCleanupDTO(time() - (60 * 15));
        $cleanupUseCase->execute($dto);
    }
}
