<?php

namespace App\Http\Controllers;

use App\Models\Personal;
use App\Models\TipoPersonal;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PersonalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $personal = Personal::with(['user', 'tipoPersonal'])
            ->latest()
            ->paginate(15);

        return view('personal.index', compact('personal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tiposPersonal = TipoPersonal::all();
        return view('personal.create', compact('tiposPersonal'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'tipo_personal' => ['required', 'exists:tipo_personal,id_tipo_personal'],
            'nivel_academico' => ['required', 'string', 'max:50'],
            'antiguedad' => ['nullable', 'integer', 'min:0'],
            'forma_pago' => ['nullable', 'string', 'max:50'],
            'jornada_laboral' => ['nullable', 'string', 'max:50'],
            'fecha_ingreso' => ['nullable', 'date'],
        ]);

        DB::beginTransaction();
        try {
            // Crear usuario con rol empleado
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'empleado', // Empleados creados por RH
            ]);

            // Crear registro de personal
            Personal::create([
                'user_id' => $user->id,
                'nombre' => $validated['name'],
                'tipo_personal' => $validated['tipo_personal'],
                'nivel_academico' => $validated['nivel_academico'],
                'antiguedad' => $validated['antiguedad'] ?? 0,
                'estado' => 'activo',
                'forma_pago' => $validated['forma_pago'],
                'jornada_laboral' => $validated['jornada_laboral'],
                'fecha_ingreso' => $validated['fecha_ingreso'] ?? now(),
            ]);

            DB::commit();

            return redirect()->route('personal.index')
                ->with('success', 'Empleado creado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al crear el empleado: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Personal $personal)
    {
        $personal->load(['user', 'tipoPersonal']);
        return view('personal.show', compact('personal'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Personal $personal)
    {
        $tiposPersonal = TipoPersonal::all();
        $personal->load('user');
        return view('personal.edit', compact('personal', 'tiposPersonal'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Personal $personal)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($personal->user_id)],
            'tipo_personal' => ['required', 'exists:tipo_personal,id_tipo_personal'],
            'nivel_academico' => ['required', 'string', 'max:50'],
            'antiguedad' => ['nullable', 'integer', 'min:0'],
            'estado' => ['required', 'in:activo,pasivo,inactivo'],
            'forma_pago' => ['nullable', 'string', 'max:50'],
            'jornada_laboral' => ['nullable', 'string', 'max:50'],
            'fecha_ingreso' => ['nullable', 'date'],
        ]);

        DB::beginTransaction();
        try {
            // Actualizar usuario
            $personal->user->update([
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]);

            // Actualizar personal
            $personal->update([
                'nombre' => $validated['name'],
                'tipo_personal' => $validated['tipo_personal'],
                'nivel_academico' => $validated['nivel_academico'],
                'antiguedad' => $validated['antiguedad'] ?? 0,
                'estado' => $validated['estado'],
                'forma_pago' => $validated['forma_pago'],
                'jornada_laboral' => $validated['jornada_laboral'],
                'fecha_ingreso' => $validated['fecha_ingreso'],
            ]);

            DB::commit();

            return redirect()->route('personal.index')
                ->with('success', 'Empleado actualizado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Error al actualizar el empleado: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Personal $personal)
    {
        DB::beginTransaction();
        try {
            $user = $personal->user;
            $personal->delete();
            $user->delete();

            DB::commit();

            return redirect()->route('personal.index')
                ->with('success', 'Empleado eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Error al eliminar el empleado: ' . $e->getMessage());
        }
    }
}
