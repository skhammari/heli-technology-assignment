<?php

	namespace App\Services;

	use App\Models\User;

	class AuthService
	{
		public function CreateUser(array $data)
		{
			$prevUser = User::where('email', $data['email'])->first();
			if ($prevUser) {
				throw new \Exception('User already exists', 409);
			}

			$user = User::create([
				'email'    => $data['email'],
				'password' => bcrypt($data['password'])
			]);

			return $this->newToken($user);
		}

		public function LoginUser(array $data)
		{
			$user = User::where('email', $data['email'])->first();
			if (!$user || !\Hash::check($data['password'], $user->password)) {
				throw new \Exception('Invalid credentials', 401);
			}

			return $this->newToken($user);
		}

		private function newToken($user)
		{
			$user->tokens()->delete();
			$expireDateTime = now()->addMinutes(60);
			$token = $user->createToken(name: 'auth_token', expiresAt: $expireDateTime);

			return $token->plainTextToken;
		}
	}