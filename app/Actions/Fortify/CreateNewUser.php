<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Contracts\CreatesNewUsers;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input): User
    {
        Validator::make($input, [
            'fullname' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique(User::class),
            ],
            'password' => [
                'string',
                Password::min(8)
                ->letters()
                ->mixedCase()
                ->numbers(),
                'confirmed',
            ],
        ])->validate();


        $user = User::create([
            'fullname' => $input['fullname'],
            'email' => $input['email'],
            'password' => Hash::make($input['password']),
        ]);

        $user->sendEmailVerificationNotification();

        return $user;
    }
}
