<?php

namespace App\Actions\Fortify;

use App\Models\User;
use App\Models\BlackList;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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

        $validator = Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users', function ($attribute, $value, $fail) {
                // Check if the email domain is "ucsy.edu.mm"
                if (strpos($value, '@ucsy.edu.mm') === false) {
                    $fail('The '.$attribute.' must be a valid email from UCSY.');
                }
            }],
            'gender' => 'required',
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ]);

        $validator->validate();
        $blacklisted = BlackList::where('email', $input['email'])->exists();

        if (!$blacklisted) {
            return User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'gender' => $input['gender'],
                'password' => Hash::make($input['password']),
            ]);
        }
    }
}
