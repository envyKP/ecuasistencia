<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\EaRoles;



class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */


    public function index()
    {
        $roles = EaRoles::all();
        $datosUsuarios['usuarios'] = User::orderBy('rol', 'asc')->paginate(10);

        return view('configUsuarios.home')->with($datosUsuarios)->with(compact('roles'));

    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $inputs = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
        ];

        $rules = [

            'name' => ['required', 'string', 'min:7'],
            'username' =>['required', 'string', 'min:6'],
            'password' =>['required',
                           'string',
                           'min:8',              //must be at least 8 characters in length
                           'regex:/[a-z]/',      //must contain at least one lowercase letter
                           'regex:/[A-Z]/',      //must contain at least one uppercase letter
                           'regex:/[0-9]/',      //must contain at least one digit
                           'regex:/[@$!%*#?&_-]/', //must contain a special character
                         ],

        ];

        $messages = [ "password.regex" => 'Su contraseña debe debe contener al menos 1 mayúscula, 1 minúscula, 1 numérico y 1 carácter especial.',
                      "password.min" => 'Su contraseña debe tener más de 8 caracteres.',
                      "name.min" => "Su nombre debe tener más de 7 caracteres",
                      "username.min" => "Su username debe tener más de 6 caracteres",
                    ];

        $validation = \Validator::make( $inputs, $rules, $messages );

        if ( $validation->fails() ) {
            //print_r( $validation->errors()->all() );
            //dd( $validation->errors()->first('password') );
            $errors = $validation->errors();

            return \redirect()->route('UserController.index')->with(['errors' =>$errors]);

        } else {

            try {

                $datosUsuario  = $request->except('_token','_method','password_confirmation');
                $datosUsuario['status'] = 1;

                //hasheo la clave antes de guardarla
                $datosUsuario['password'] = Hash::make($request->password);

                if ($request->hasfile('foto')){
                    //modifico el campo foto, con la realpath de la foto, y guardo en el storage
                    $nombreArchivo = $request->file('foto')->getClientOriginalName();
                    $datosUsuario['foto']= $request->file('foto')->storeAs('fotosUsuarios', $nombreArchivo, 'public');
                }

                $mensaje=User::insert($datosUsuario);

                if ($mensaje){
                    $respuesta = $request->name;
                    return redirect()->route('UserController.index')->with(['mensaje' => 'Usuario: '.$request->name .' creado!...']);
                }

            }catch (Exception $e){
                $error = $e->getMessage();
                return redirect()->route('UserController.index')->with([ 'error' => $error ]);
            }

        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $roles = EaRoles::all();

        if ( empty($request->username)){

           return redirect()->route('UserController.index');

        }else {

           $usuario= User::where('username', $request->username)->first();
           $datosUsuarios['usuarios'] = array( $usuario);

           if ( is_null( $usuario) ){

                return redirect()->route('UserController.index')->with(['error' => 'Usuario: '.$request->username.' no configurado']);

           }else {

               return view( 'configUsuarios.home')->with($datosUsuarios)
                                                  ->with(compact('roles')) ;
           }

        }

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        $datosUsuario = $request->except('_token', '_method', 'id');
        $usuario = User::Where("id", $request->id)->first();

        $inputs = [
            'name' => $request->name,
            'username' => $request->username,
            'password' => $request->password,
        ];

        $rules = [

            'name' => ['required', 'string', 'min:7'],
            'username' =>['required', 'string', 'min:6'],
            'password' =>['required',
                           'string',
                           'min:8',              //must be at least 8 characters in length
                           'regex:/[a-z]/',      //must contain at least one lowercase letter
                           'regex:/[A-Z]/',      //must contain at least one uppercase letter
                           'regex:/[0-9]/',      //must contain at least one digit
                           'regex:/[@$!%*#?&_-]/', //must contain a special character
                         ],

        ];

        $messages = [ "password.regex" => 'Su contraseña debe debe contener al menos 1 mayúscula, 1 minúscula, 1 numérico y 1 carácter especial.',
                      "password.min" => 'Su contraseña debe tener más de 8 caracteres.',
                      "name.min" => "Su nombre debe tener más de 7 caracteres",
                      "username.min" => "Su username debe tener más de 6 caracteres",
                    ];

        $validation = \Validator::make( $inputs, $rules, $messages );


        if ( $validation->fails()) {
            # code...
            $errors = $validation->errors();
            return \redirect()->route('UserController.index')->with(['errors' => $errors]);

        }else {

            if ($request->hasfile('foto')) {

                Storage::delete('public/'. $usuario->foto );

                $nombreArchivo = $request->file('foto')->getClientOriginalName();
                $datosUsuario['foto']= $request->file('foto')->storeAs('fotosUsuarios', $nombreArchivo, 'public');

            }

            if ( is_null($request->password )) {
                unset($datosUsuario['password']);
            } else {
                $datosUsuario['password'] = Hash::make($request->password);
            }


            try {
                //code...
                User::Where("id", $request->id)->update($datosUsuario);

                $usuario = User::Where("id", $request->id)->first();

                return redirect()->route('UserController.index')->with(['mensaje' => 'Usuario: '.$request->name.' actualizado!...']);

            } catch (\Exception $e) {
                $error = $e->getMessage();
                return redirect()->route('UserController.index')->with([ 'error' => $error ]);
            }


        }

    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function change_pass(Request $request)
    {


        $inputs = [
           'password_new' => $request->password_new,
        ];

        $rules = [
            'password_new' =>['required',
                            'string',
                            'min:8',              //must be at least 8 characters in length
                            'regex:/[a-z]/',      //must contain at least one lowercase letter
                            'regex:/[A-Z]/',      //must contain at least one uppercase letter
                            'regex:/[0-9]/',      //must contain at least one digit
                            'regex:/[@$!%*#?&_-]/', //must contain a special character
                        ],

        ];

        $messages = [ "password_new.regex" => 'Su contraseña debe debe contener al menos 1 mayúscula, 1 minúscula, 1 numérico y 1 carácter especial.',
                      "password_new.min" => 'Su contraseña debe tener más de 8 caracteres.',
                    ];

        $validation = \Validator::make( $inputs, $rules, $messages );

        if ($validation->fails()) {
            # code...
            $errors = $validation->errors();

            return \redirect()->back()->with('errors', $errors);

        } else {

            $datosUsuario['pass_change'] = 'S';
            $datosUsuario['password'] = Hash::make($request->password);

            User::Where("id", $request->id)->update($datosUsuario);

            return \redirect()->route('home');
        }

    }



    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     * @param  \Illuminate\Http\Request  $request
     */

    // Desactiva usuario - No elimina el registro
    public function destroy(User $user, Request  $request )
    {

        $roles = EaRoles::all();
        $datosUsuario = $request->except('_token', '_method');


        if ( strcmp( $request->estado, $user->estado) !== 0 ) {
            User::where('id', $user->id)
                ->update(['estado' => $request->estado]);
        }
           return redirect()->route('UserController.index')->with(compact('roles'));

    }
}
