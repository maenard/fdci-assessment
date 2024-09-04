<?php

namespace App\Repositories;

use App\Classes\JsonResponseFormat;
use App\Models\File;
use App\Models\User;
use App\Services\FileUploadService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class AuthRepository extends JsonResponseFormat
{
    /**
     * @param array $data
     * @return array
     */
    public function login($data): array
    {
        if (!Auth::attempt($data)) {
            return [
                'message' => 'Invalid credentials',
                'status' => 401
            ];
        }

        $user = User::with(['files', 'role.abilities.route'])->find(Auth::id());

        return [
            'message' => 'Login successful',
            'body' => $user
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function logout($data): array
    {
        Auth::guard('web')->logout();
        return [
            'message' => 'Logout successful'
        ];
    }

    /**
     * @param array $data
     * @return array
     */
    public function register($data): array
    {
        DB::beginTransaction();
        try {
            $user = User::create($data);

            DB::commit();
            return [
                'message' => 'User created successfully',
                'body' => $user
            ];
        } catch (\Exception $e) {
            DB::rollBack();
            return [
                'error' => $e->getMessage(),
                'status' => 500
            ];
        }
    }
}
