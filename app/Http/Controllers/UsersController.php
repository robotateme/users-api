<?php

namespace App\Http\Controllers;

use App\Http\Enums\UsersKeywordsEnum;
use App\Http\Requests\UserRegisterRequest;
use Domains\User\Application\DTOs\UserRegistrationDTO;
use Domains\User\Application\UseCases\Exceptions\NicknameAlreadyExists;
use Domains\User\Application\UseCases\Exceptions\UseCaseException;
use Domains\User\Application\UseCases\UserRegistrationUseCase;
use Illuminate\Http\JsonResponse;
use Symfony\Component\VarExporter\Exception\ExceptionInterface;
use Symfony\Component\VarExporter\Instantiator;
use Domains\User\Application\UseCases\ListUsersUseCase;

class UsersController extends Controller
{
    /**
     * @throws ExceptionInterface
     */
    public function register(UserRegisterRequest $request, UserRegistrationUseCase $useCase): JsonResponse
    {
        $fileUri = $request->file('avatar')
            ?->store(UsersKeywordsEnum::AVATAR_STORAGE->value, 'public');

        $dto = Instantiator::instantiate(UserRegistrationDTO::class, [
            'avatarUri' => $fileUri,
            'nickname' => $request->get('nickname'),
        ]);

        try {
            return new JsonResponse([
                'success' => $useCase->execute($dto),
                'data' => $dto,
            ], 201);
        } catch (NicknameAlreadyExists $e) {
            return response()->json([
                'message' => $e->getMessage(),
                'success' => false,
            ], 409);
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
        } catch (UseCaseException $e) {
            return new JsonResponse([
                'message' => $e->getMessage(),
                'success' => false,
            ], 500);
        }
    }
}
