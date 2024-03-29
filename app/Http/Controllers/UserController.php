<?php

	namespace App\Http\Controllers;

	use App\Http\Requests\UserSignupRequest;
	use App\Services\AuthService;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Request;

	class UserController extends Controller
	{
		public function signup(UserSignupRequest $request, AuthService $authService): JsonResponse
		{
			$validated = $request->validated();

			try {
				$token = $authService->CreateUser($validated);
				return response()->json([
					'message' => 'User created successfully',
					'token'   => $token
				], 201);
			} catch (\Exception $e) {
				return response()->json([
					'message' => $e->getMessage()
				], $e->getCode());
			}
		}

		public function login(Request $request, AuthService $authService): JsonResponse
		{
			// validate request
			$request->validate([
			    'email' => 'required|email',
			    'password' => 'required'
			]);

			try {
				$token = $authService->LoginUser($request->all());
				return response()->json([
					'message' => 'User logged in successfully',
					'token'   => $token
				]);
			} catch (\Exception $e) {
				return response()->json([
					'message' => $e->getMessage()
				], $e->getCode());
			}
		}
	}
