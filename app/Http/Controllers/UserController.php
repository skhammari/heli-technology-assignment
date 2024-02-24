<?php

	namespace App\Http\Controllers;

	use App\Http\Requests\UserSignupRequest;
	use App\Models\User;
	use Illuminate\Http\JsonResponse;
	use Illuminate\Http\Request;

	class UserController extends Controller
	{
		public function signup(UserSignupRequest $request): JsonResponse
		{
			$validated = $request->validated();

			$prevUser = User::where('email', $validated['email'])->first();
			if ($prevUser) {
				return \Response::json([
					'message' => 'User already exists'
				])->setStatusCode(409);
			}

			$user = User::create([
				'email'    => $validated['email'],
				'password' => bcrypt($validated['password'])
			]);

			$user->tokens()->delete();
			$expireDateTime = now()->addMinutes(60);
			return \Response::json([
				'message' => 'User created successfully',
				'token'   => $user->createToken(name: 'auth_token', expiresAt: $expireDateTime)->plainTextToken
			])->setStatusCode(201);
		}

		public function login(Request $request): JsonResponse
		{
			// validate request
			$request->validate([
			    'email' => 'required|email',
			    'password' => 'required'
			]);

			$user = User::where('email', $request['email'])->first();
			if (!$user || !\Hash::check($request['password'], $user->password)) {
				return \Response::json([
					'message' => 'Invalid credentials'
				])->setStatusCode(401);
			}

			$user->tokens()->delete();
			$expireDateTime = now()->addMinutes(60);
			return \Response::json([
				'message' => 'User logged in successfully',
				'token'   => $user->createToken(name: 'auth_token', expiresAt: $expireDateTime)->plainTextToken
			])->setStatusCode(200);
		}
	}
