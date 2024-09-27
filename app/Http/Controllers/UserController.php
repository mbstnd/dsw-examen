<?php

namespace App\Http\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\User as AuthUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    private const SINGULAR_MIN = 'usuario';
    private const SINGULAR_MAY = 'Usuario';
    private const PLURAL_MIN = 'usuarios';
    private const PLURAL_MAY = 'Usuarios';

    private $properties = [
        'title' => [
            'genero' => 'm',
            'name' => self::SINGULAR_MAY,
            'singular' => self::SINGULAR_MAY,
            'plural' => self::PLURAL_MAY,
        ],
        'view' => [
            'index' => 'backoffice.mantenedor.' . self::SINGULAR_MIN
        ],
        'actions' => [
            'new' => '/backoffice/users/new',
        ],
        'routes' => [
            'index' => self::PLURAL_MIN . '.index'
        ],
        'fields' => [
            [
                'id' => 1,
                'name' => 'nombre',
                'label' => 'Nombre Completo',
                'control' => 'input',
                'type' => 'text',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,

            ],
            [
                'id' => 2,
                'name' => 'email',
                'label' => 'Correo Electronico',
                'control' => 'input',
                'type' => 'email',
                'required' => false,
                'inVerEnableDisableDelete' => true,
                'inEditar' => true,
                'inNuevo' => true,

            ],
            [
                'id' => 3,
                'name' => 'password',
                'label' => 'Contrasena',
                'control' => 'input',
                'type' => 'password',
                'required' => false,
                'inVerEnableDisableDelete' => false,
                'inEditar' => true,
                'inNuevo' => true,

            ],
            [
                'id' => 4,
                'name' => 'rePassword',
                'label' => 'Reingrese Contrasena',
                'control' => 'input',
                'type' => 'password',
                'required' => false,
                'inVerEnableDisableDelete' => false,
                'inEditar' => true,
                'inNuevo' => true,

            ],

        ]
    ];


    public function formularioLogin()
    {
        if (Auth::check()) {
            return redirect()->route('backoffice.dashboard');
        }
        return view('usuario.login');
    }

    public function formularioNuevo()
    {
        if (Auth::check()) {
            return redirect()->route('backoffice.dashboard');
        }
        return view('usuario.registrar');
    }

    public function login(Request $_request)
    {

        $_request->validate([
            'email' => 'required|email',
            'password' => 'required|string'
        ], $this->mensajes);

        $credenciales = $_request->only('email', 'password');

        // var_dump($credenciales);

        if (Auth::attempt($credenciales)) {

            $user = Auth::user();
            if (!$user->activo) {
                Auth::logout();
                return redirect()->route('usuario.login')->withErrors(['email' => 'El usuario se encuentra desactivado.']);
            }
            //Autenticacion exitosa
            $_request->session()->regenerate();
            return redirect()->route('backoffice.dashboard');
        }

        return redirect()->back()->withErrors(['email' => 'El usuario o contraseña son incorrectos.']);
    }


    public function registrar(Request $_request)
    {
        // Mensajes personalizados para la validación
        $mensajesValidacion = [
            'nombre.required' => 'El nombre es un campo obligatorio.',
            'apellido.required' => 'El apellido es un campo obligatorio.',
            'email.required' => 'El correo electrónico es un campo obligatorio.',
            'email.email' => 'El formato del correo electrónico no es válido.',
            'email.unique' => 'Este correo electrónico ya está en uso.',
            'password.required' => 'La contraseña es un campo obligatorio.',
            'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
            'password.confirmed' => 'Las contraseñas deben coincidir.',
        ];

        // Validación de los datos de entrada
        $_request->validate([
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255', // Agregado para validar el apellido
            'email' => 'required|email|max:255|unique:users,email', // Evitar duplicados
            'password' => 'required|string|min:8|confirmed', // Asegura que las contraseñas coincidan
        ], $mensajesValidacion);

        // Obtener los datos necesarios
        $datos = $_request->only('nombre', 'apellido', 'email', 'password'); // Incluido apellido

        try {
            // Crear un nuevo usuario en la base de datos
            User::create([
                'nombre' => $datos['nombre'],
                'apellido' => $datos['apellido'], // Asegúrate de que este campo exista en la migración
                'email' => $datos['email'],
                'password' => Hash::make($datos['password']), // Encriptar la contraseña
            ]);

            // Redirigir a la página de inicio de sesión con un mensaje de éxito
            return redirect()->route('usuario.login')->with('success', 'Usuario creado con éxito');

        } catch (QueryException $e) {
            // Manejar errores relacionados con la base de datos
            if ($e->getCode() == 23000) {
                return back()->withErrors(['message' => 'Error al crear usuario, porque el correo electrónico ya existe']);
            }
            return back()->withErrors(['message' => 'Error Desconocido: ' . $e->getMessage()]);
        }
    }


    public function logout(Request $_request)
    {
        Auth::logout();
        $_request->session()->invalidate();
        $_request->session()->regenerateToken();
        return redirect()->route('usuario.login');

    }

    public function index()
    {
        $user = Auth::user();
        if ($user == null){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }

        $datos = User::all();

        return view($this->properties ['view']['index'],[
            'user' => $user,
            'registros' => $datos,
            'action' => $this->properties['actions'],
            'titulo' => $this->properties['title'],
            'campos' => $this->properties['fields'],
        ]);
    }


    public function getById($_id)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }
        if ($_id === null){
            $datos = User::all();
            $datos->each(function ($item){
                if ($item->imagen){
                    $item->imagen = base64_encode($item->imagen);
                }
            });
        }else {
            $datos = User::findOFail($_id);
        }
        return response()->json([
            'data' => $datos
        ]);
    }


    public function enable($_id)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        $registro = User::findOrFail($_id);

        if ($registro->id != $user->id) {
            $registro->activo = true;

            try {
                $registro->save();
                return redirect()->route($this->properties['routes']['index'])->with(
                    'success',
                    $this->getTextToast($this->properties['title']['singular'], 'enable', 'success', $registro->nombre, null)
                );
            } catch (Exception $e) {
                return redirect()->back()->with(
                    'error',
                    $this->getTextToast(
                        $this->properties['title']['singular'],
                        'enable',
                        'error',
                        $registro->nombre,
                        null
                    ) . ' ' . $e->getMessage()
                );
            }
        } else {
            return redirect()->back()->with(
                'error',
                $this->getTextToast($this->properties['title']['singular'],
                    'enable', 'error',
                    $registro->nombre,
                    'El usuario no puede realizar acciones sobre sí mismo')
            );
        }
    }

    public function disable($_id)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        $registro = User::findOrFail($_id);

        if ($registro->id != $user->id){
            $registro->activo = false;
            try {
                $registro->save();
                return redirect()->route($this->properties['routes']['index'])->with('success', $this->getTextToast($this->properties['title']['singular'], 'disable', 'success', $registro->nombre, null));
            } catch (Exception $e){
                return redirect()->back()->with('error', $this->getTextToast($this->properties['title']['singular'], 'disable', 'error', $registro->nombre, null) . $e->getMessage());
            }
        }else {
            return redirect()->back()->with('error', $this->getTextToast($this->properties['title']['singular'], 'disable', 'error', $registro->nombre, 'El usuario no puede realizar acciones sobre si mismo'));
        }
    }

    public function delete($_id)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }

        $registro = User::findOrFail($_id);
        if ($registro->id != $user->id){
            try {
                $registro->delete();
                return redirect()->route($this->properties['routes']['index'])->with('success', $this->getTextToast($this->properties['title']['singular'], 'delete', 'success', $registro->nombre, null));
            } catch (Exception $e){
                return redirect()->back()->with('error', $this->getTextToast($this->properties['title']['singular'], 'delete', 'error', $registro->nombre, null) . $e->getMessage());
            }
        }else {
            return redirect()->back()->with('error', $this->getTextToast($this->properties['title']['singular'], 'delete', 'error', $registro->nombre, 'El usuario no puede realizar acciones sobre si mismo' ));
        }
    }

    public function create(Request $_request)
    {
        $user = Auth::user();
        if ($user == null) {
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesión activa.']);
        }



        // Validar solicitud uso de unique: unique:tabla, campo

        $_request->validate([
            'usuario_nombre' => 'required|string|max:255',
            'usuario_email' => 'required|email|unique:users,email',
            'usuario_password' => 'required|',
        ], $this->mensajes);

        $datos = $_request->only('usuario_nombre', 'usuario_email', 'usuario_password', 'usuario_rePassword');

        if($datos['usuario_password'] != $datos['usuario_rePassword']){
            return back()->withErrors(['message' => 'Las contrasenas ingresadas no son iguales']);
        }

        try {
            // Insertar el registro en la base de datos
            User::create([
                'nombre' => $_request->usuario_nombre,
                'email' => $_request->usuario_email,
                'password' => Hash::make($_request->usuario_password),
                'rol_id' => $_request->usuario_rol_id,
            ]);
            return redirect()->back()->with('success', $this->getTextToast($this->properties['title']['singular'], 'create', 'success', $_request->usuario_nombre, null));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $this->getTextToast($this->properties['title']['singular'], 'create', 'error', $_request->usuario_nombre, null) . $e->getMessage());
        }
    }

    public function update(Request $_request, $_id)
    {
        $user = Auth::user();
        if ($user == null){
            return redirect()->route('usuario.login')->withErrors(['message' => 'No existe una sesion activa']);
        }

        $_request->validate([
            'usuario_nombre' => 'required|string|max:255',
            'usuario_email' => 'required|email|max:255',
        ], $this->mensajes);

        $registro = User::findOrFail($_id);

        $datos = $_request->only('usuario_nombre' , 'usuario_email','usuario_password', 'usuario_rePassword');

        $cambios = 0;

        // solo si es diferente, actualiza

        if ($registro->nombre != $datos ['usuario_nombre']){
            $registro->nombre = $datos['usuario_nombre'];
            $cambios += 1;
        }
        if ($registro->email != $datos['usuario_email']){
            $registro->email = $datos['usuario_email'];
            $cambios += 1;
        }
        if($datos['usuario_password'] != ''){
            if ($datos['usuario_password'] != $datos['usuario_rePassword']){
                return back()->withErrors(['message' => 'Las contrasenas ingresadas no son iguales']);
            } else {
                $registro->password = $datos ['usuario_password'];
                $cambios +=1;
            }
        }

        if ($cambios > 0){
            try{
                $registro->save();
                return redirect()->back()->with('success', "[id: $registro->id] [Usuario: $registro->nombre] actualizado con exito" );
            } catch (Exception $e) {
                return redirect()->back()->with('error', 'Error al actualizar el usuario:' . $e->getMessage());
            }
        }else {
            return redirect()->back()->with('error', "[id: $registro->id] [Usuario: $registro->nombre] no se realizaron cambios");
        }
    }
}
