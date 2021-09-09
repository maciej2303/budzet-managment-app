<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Budget;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,NULL,id,deleted_at,NULL'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    protected function create(array $data)
    {
        if ($user = User::withTrashed()->where('email', '=', $data['email'])->first()) {
            $user->restore();
            $user->update([
                'name' => $data['name'],
                'password' => Hash::make($data['password']),
            ]);
            $budget = Budget::create(['creator_id' => $user->id]);

            $user->budget_id = $budget->id;
            $user->save();
        } else {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);

            $budget = Budget::create(['creator_id' => $user->id]);

            $user->budget_id = $budget->id;
            $user->save();
        }
        return $user;
    }

    public function registerToBudgetForm($budget)
    {
        return view('auth.register-to-budget')->with(['budget' => $budget]);
    }

    public function registerToBudget(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = User::create($request->all())));
        $this->guard()->login($user);
        return redirect($this->redirectPath());
    }
}
