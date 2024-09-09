<?php

namespace App\Http\Controllers\Admin;


use App\Http\Requests\CreateUserRequest;
use App\Http\Requests\UpdateUserClaveRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Repositories\UserRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use App\Models\Sintoma;
use DB;
use Carbon\Carbon;
use App\Models\Establecimiento;
use App\Models\Grado;
use Flash;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use Caffeinated\Shinobi\Models\Role;
use Caffeinated\Shinobi\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;


class UserController extends AppBaseController
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepo)
    {
        $this->userRepository = $userRepo;
    }

    /**
     * Display a listing of the User.
     *
     * @param Request $request
     * @return Response
     */
    
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));
        $users = $this->userRepository->all();

        return view('admin.users.index')
            ->with('users', $users);
    }


    /**
     * Show the form for creating a new User.
     *
     * @return Response 
     */
    public function create()
    {
        //$establecimiento_id=Establecimiento::pluck('nombre_establecimiento','id');
        $establecimientos = DB::table('establecimientos')->pluck("nombre","id")->all();
        //$sintomas = DB::table('sintomas')->pluck("descripcion","id")->all();
        
        $tipo=1; /// Crear
        
        return view('admin.users.create',compact(["establecimientos","tipo"]));
    
    }

    /**
     * Store a newly created User in storage.
     *
     * @param CreateUserRequest $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        $user = new User;

        $c1 = User::Where('dni',$request->dni)->count();
        $c2 = User::Where('email',$request->email)->count();
        
        if($c1>0){
            Flash::error('Usuario ya se encuentra registrado con ese dni');
        }
        else{
            if($c2>0){
                Flash::error('Usuario ya se encuentra registrado con ese correo');
            } 
            else{

                //Asignamos el dni
                $user->dni=$request->dni;
                //Asignamos el nombre
                $user->nombres=strtoupper( $request->nombres ) ;
                //Asignamos el apellido
                $user->apellido_paterno=strtoupper( $request->apellido_paterno ) ;
                //Asignamos el telefono
                $user->apellido_materno=strtoupper( $request->apellido_materno ) ;
                //Asignamos el telefono
                $user->telefono=$request->telefono;
                //Asignamos el establecimiento
                $user->establecimiento_id=$request->establecimiento_id;
                //Buscamos la descripcion del grado
                $establecimiento = Establecimiento::findOrFail($request->establecimiento_id);
                //asignamos el nombre del establecimiento
                $user->nombre_establecimiento=$establecimiento->nombre;
                //Buscamos el nombre del establecimiento
                $user->grado=$request->grado;
                //Asignamos el email
                $user->email=$request->email;
                //Asignamos el password
                $user->password= bcrypt( $request->password ); 
                //Guardamos el usuario        
                $user->rol=$request->rol;
                $user->cip=$request->cip;            
        //        $nivel=$establecimiento->nivel_id; 
                $user->estado=1;  
                $user->name = $request->nombres.' '.$request->apellido_paterno.' '.$request->apellido_materno;
            
                
                $user->save();        

                Flash::success('Usuario grabado con exito.');
            }
        }
        
        return redirect(route('users.index'));
    }

    public function show($id)
    {
        $user = $this->userRepository->findWithoutFail($id);

        if (empty($user)) {
            Flash::error('User not found');

            return redirect(route('users.index'));
        }

        return view('admin.users.show')->with('user', $user);
    }

    public function edit($id)
    {
        $user = $this->userRepository->findWithoutFail($id);
        
        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }
        
        //$establecimiento = DB::table('establecimientos')->pluck("nombre","id")->all();
        $establecimientos = DB::table('establecimientos')->pluck("nombre","id")->all();
        $grado=Grado::pluck('descripcion','id')->all();
        
        $tipo=2; //editar
            
        return view('admin.users.edit') 
                ->with('user', $user)
                ->with('establecimientos',$establecimientos)
                ->with('grado',$grado)
                ->with('tipo',$tipo);
            
    }

    public function update($id, Request $request)
    {
        $user = User::where('id', $id)->first();

        if (empty($user)) {
            Flash::error('Usuario no encontrado');

            return redirect(route('users.index'));
        }

        $user->name = $request->nombres.' '.$request->apellido_paterno.' '.$request->apellido_materno;
        $user_encontrado_dni = User::Where('dni',$request->dni)->first();
        
        //cuando hay registro de usuario
        if(is_object($user_encontrado_dni)){

            if($user_encontrado_dni->id!=$user->id){
                Flash::error('Usuario ya se encuentra registrado con ese dni, busque y edite');
            }
            else
            {
                $user->nombres=strtoupper( $request->nombres ) ;
                //Asignamos el apellido
                $user->apellido_paterno=strtoupper( $request->apellido_paterno ) ;
                //Asignamos el telefono
                $user->apellido_materno=strtoupper( $request->apellido_materno ) ;
                //Asignamos el telefono
                $user->telefono=$request->telefono;
                //Asignamos el establecimiento
                $user->establecimiento_id=$request->establecimiento_id;
                //Buscamos la descripcion del grado
                $establecimiento = Establecimiento::findOrFail($request->establecimiento_id);
                //asignamos el nombre del establecimiento
                $user->nombre_establecimiento=$establecimiento->nombre;
                //Buscamos el nombre del establecimiento
                $user->grado=$request->grado;        
                
                //Asignamos el email
                if($user->email!=$request->email){
                    $busca_email = User::where('email', $request->email)->first();
                    if (is_object($busca_email)) {
                        Flash::error('Email ya se encuentra registrado');
                        return redirect(route('users.index'));
                    }
                    else                
                    { 
                        $user->email=$request->email; 
                    }
                }
                //Asignamos el password
                $user->password= bcrypt( $request->password ); 
                //Guardamos el usuario        
                $user->rol=$request->rol;
                $user->cip=$request->cip;
                $user->estado = isset($request->status) ? 1 : 0;
                $user->save();        

                Flash::success('Usuario actualizado correctamente.');
            }

        }
        else
        {
            $user_encontrado_email = User::Where('email',$request->email)->first();
            if(is_object($user_encontrado_email)){
                if($user_encontrado_email->id!=$user->id)
                    Flash::error('Usuario ya se encuentra registrado con ese correo, elige otro correo');
            }
            else{
            
                //Asignamos el dni
                $user->dni=$request->dni;
                //Asignamos el nombre
                $user->nombres=strtoupper( $request->nombres ) ;
                //Asignamos el apellido
                $user->apellido_paterno=strtoupper( $request->apellido_paterno ) ;
                //Asignamos el telefono
                $user->apellido_materno=strtoupper( $request->apellido_materno ) ;
                //Asignamos el telefono
                $user->telefono=$request->telefono;
                //Asignamos el establecimiento
                $user->establecimiento_id=$request->establecimiento_id;
                //Buscamos la descripcion del grado
                $establecimiento = Establecimiento::findOrFail($request->establecimiento_id);
                //asignamos el nombre del establecimiento
                $user->nombre_establecimiento=$establecimiento->nombre;
                //Buscamos el nombre del establecimiento
                $user->grado=$request->grado;        
                
                //Asignamos el email
                if($user->email!=$request->email){
                    $busca_email = User::where('email', $request->email)->first();
                    if (empty($busca_email)) {
                        Flash::error('Email ya se encuentra registrado');
                        return redirect(route('users.index'));
                    }
                    else                
                        $user->email=$request->email;
                }
                //Asignamos el password
                $user->password= bcrypt( $request->password ); 
                //Guardamos el usuario        
                $user->rol=$request->rol;
                $user->cip=$request->cip;
                $user->save();        

                Flash::success('Usuario actualizado correctamente.');
            }
        }
        return redirect(route('users.index'));
    }

    public function destroy($id)
    {
        $update_user = User::where('id', $id)->first();

        if (empty($update_user)) {
            Flash::error('User no encontrado');

            return redirect(route('users.index'));
        }

        $update_user->estado = 0;
        $update_user->save(); 

        Flash::success('Usuario borrado correctamente.');

        return redirect(route('users.index'));
    }  

    public function getDivision(Request $request, $establecimiento_id){
        
        if($request->ajax()){
            $establecimientos = Establecimiento::find($establecimiento_id);
                
            if($establecimientos->nivel_id==1){                
                    $division = DB::table('rubros')
                                        ->join('establecimiento_rubro','establecimiento_rubro.rubro_id','rubros.id')
                                        ->where('establecimiento_id',$establecimiento_id)
                                        ->get();
            }
            else
            {
                    //$division = Division::where('establecimiento_id',$establecimiento_id)
                    //                    ->get();
                    $division = DB::table('divisions')
                                        ->join('division_establecimiento','division_establecimiento.division_id','divisions.id')
                                        ->where('establecimiento_id',$establecimiento_id)
                                        ->get();
            }    
            
            return response()->json($division);        
        }
    }
    
    public function editar_clave($id)
    {
        if($id==Auth::user()->id){
            $user = $this->userRepository->findWithoutFail($id);
        
            if (empty($user)) {
                Flash::error('Usuario no encontrado');
                return view('home');
            }

            return view('site.users.editar_clave')->with('user', $user);
        }
        else
        {
            return view('home');
        }
    }

   public function update_clave(UpdateUserClaveRequest $request,$id)
    {
        
        if (Hash::check($request->mypassword, Auth::user()->password)){
                DB::table('users')
                ->where('id', $id )
                        ->update(['password' => bcrypt($request->password)]);

                Flash::success('Contraseña actualizada correctamente');
                return view('home');
                
        }
        else
        {   
            Flash::error('No se ha podido cambiar la contraseña, la contraseña ingresada no es correcta');
            return view('home');
            
        }
    }

    public function subir_foto(Request $request,$id)
    {
        $input = $request->all();
        
        if ($request->hasFile('photo')){
            $input['photo'] = '/upload/photo/'.str_slug($id, '-').'.'.$request->photo->getClientOriginalExtension();
            $name_photo=str_slug($id, '-').'.'.$request->photo->getClientOriginalExtension();
            $request->photo->move(public_path('/upload/photo/'), $input['photo']);
        }
        
        DB::table('users')
                ->where('id', $id )
                        ->update(['photo' => $name_photo]);

        return view('home');
    }

    public function manual($id)
    {
        return view('admin.manual.index')
        ->with('id', $id);   ;     
    }
}
