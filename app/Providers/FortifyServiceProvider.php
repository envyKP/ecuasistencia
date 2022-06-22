<?php

namespace App\Providers;

use App\Actions\Fortify\CreateNewUser;
use App\Actions\Fortify\ResetUserPassword;
use App\Actions\Fortify\UpdateUserPassword;
use App\Actions\Fortify\UpdateUserProfileInformation;
use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Laravel\Fortify\Fortify;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Auth;

class FortifyServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {


        Fortify::createUsersUsing(CreateNewUser::class);
        Fortify::updateUserProfileInformationUsing(UpdateUserProfileInformation::class);
        Fortify::updateUserPasswordsUsing(UpdateUserPassword::class);
        Fortify::resetUserPasswordsUsing(ResetUserPassword::class);

        RateLimiter::for('login', function (Request $request) {
            return Limit::perMinute(1)->by($request->email . $request->ip());
        });


        /*RateLimiter::for('two-factor', function (Request $request) {
            return Limit::perMinute(5)->by($request->session()->get('login.id'));
        });
        */

        Fortify::loginView(function () {
            return view('auth.login');
        });


        Fortify::authenticateUsing(function (Request $request) {

            $num_intentos = 0;

          /*  $user_exists = User::where('username', $request->username)
                ->exists();
            */

            if (User::where('username',  $request->username)->exists()) {
               
                $user = User::where('username', $request->username)
                    ->first();

                if ($user->num_intentos == 2) {
                    # code...
                    $num_intentos =  $user->num_intentos + 1;

                    User::where('id', $user->id)
                        ->update([
                            'estado' => 'I',
                            'status' => '0',
                            'num_intentos' => $num_intentos
                        ]);

                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    back()->with('error', 'Cuenta bloqueada, Comuníquese con sistemas.');
                    //return abort(410, 'Cuenta suspendida, Comuníquese con sistemas.');

                }

                if (!Hash::check($request->password, $user->password) && $user->num_intentos<2) {
                    # code...

                    if (isset($user->num_intentos) && $user->num_intentos >= 1) {
                        $num_intentos =  $user->num_intentos + 1;
                    } else {
                        $num_intentos = 1;
                    }

                    User::where('id', $user->id)
                        ->where('estado', 'A')
                        ->where('status', '1')
                        ->update(['num_intentos' => $num_intentos]);

                    back()->with('error', 'Credenciales erroneas.');
                } else if ($user && Hash::check($request->password, $user->password)) {

                    return $user;
                }

            } else {

                back()->with('error', 'Credenciales erroneas.');
                // return abort(423 , 'Credenciales erroneas');


            }
        });
    }
}
