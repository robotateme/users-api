<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Enums\UsersKeywordsEnum;
use App\Http\Requests\UserRegisterRequest;
use Application\Commands\UserRegistrationCommand;
use Application\UseCases\Exceptions\ApplicationException;
use Application\UseCases\Exceptions\NicknameAlreadyExists;
use Application\UseCases\ListUsersUseCase;
use Application\UseCases\UserRegistrationUseCase;
use Illuminate\Http\JsonResponse;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\Instantiator;

class UsersController extends Controller
{
    /**
     * @throws ExceptionInterface
     */
    public function register(UserRegisterRequest $request, UserRegistrationUseCase $useCase): JsonResponse
    {
        $fileUri = $request->file('avatar')
            ?->store(UsersKeywordsEnum::AVATAR_STORAGE->value, 'public');

        $command = Instantiator::instantiate(UserRegistrationCommand::class, [
            'avatarUri' => $fileUri,
            'nickname' => $request->input('nickname'),
            'metric' => $request->input('metric'),
        ]);

        try {
            return new JsonResponse([
                'success' => $useCase->execute($command),
                'data' => $command,
            ], 201);
        } catch (NicknameAlreadyExists $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 409);
        } catch (ApplicationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    /**
     * @param ListUsersUseCase $useCase
     * @return JsonResponse
     */
    public function index(ListUsersUseCase $useCase): JsonResponse
    {
        try {
            return new JsonResponse([
                'success' => true,
                'data' => $useCase->execute(),
            ]);
        } catch (ApplicationException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }
}
