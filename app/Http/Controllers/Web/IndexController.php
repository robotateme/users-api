<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Application\UseCases\Exceptions\ApplicationException;
use Application\UseCases\ListUsersUseCase;
use Inertia\Inertia;
use Inertia\Response;

class IndexController extends Controller
{
    public function __construct(private readonly ListUsersUseCase $listUsersUseCase) {}

    public function __invoke(): Response
    {
        try {
            $users = $this->listUsersUseCase->execute();
        } catch (ApplicationException $e) {
            return abort(505, $e->getMessage());
        }

        return Inertia::render('Index', [
            'users' => $users,
        ]);
    }
}
