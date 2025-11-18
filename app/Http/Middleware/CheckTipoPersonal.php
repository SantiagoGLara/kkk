<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckTipoPersonal
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  int|string  ...$tiposPermitidos  Los IDs de tipo_personal permitidos
     */
    public function handle(Request $request, Closure $next, ...$tiposPermitidos): Response
    {
        // Verificar si el usuario está autenticado
        if (!auth()->check()) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta página.');
        }

        $user = auth()->user();

        // Verificar que el usuario sea empleado
        if (!$user->isEmpleado()) {
            abort(403, 'Esta página es solo para empleados.');
        }

        // Verificar que el usuario tenga un registro de personal
        if (!$user->personal) {
            abort(403, 'No tienes un registro de personal asignado.');
        }

        // Si se especificaron tipos permitidos, verificar que el usuario tenga uno de ellos
        if (!empty($tiposPermitidos)) {
            $tipoPersonal = $user->personal->tipo_personal;

            if (!in_array($tipoPersonal, $tiposPermitidos)) {
                abort(403, 'No tienes el tipo de personal requerido para acceder a esta página.');
            }
        }

        return $next($request);
    }
}
