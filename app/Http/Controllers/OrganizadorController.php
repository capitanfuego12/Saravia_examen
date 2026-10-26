<?php

namespace App\Http\Controllers;

use App\Models\Organizador;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganizadorController extends Controller
{
    public function index(): View
    {
        $organizadores = Organizador::withCount('eventos')
            ->orderBy('nombre')
            ->paginate(10);

        return view('admin.organizadores.index', compact('organizadores'));
    }

    public function create(): View
    {
        return view('admin.organizadores.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $organizador = Organizador::create($this->validatedData($request));

        return redirect()
            ->route('organizadores.edit', $organizador)
            ->with('success', 'El organizador se creó correctamente.');
    }

    public function edit(Organizador $organizador): View
    {
        return view('admin.organizadores.edit', compact('organizador'));
    }

    public function update(Request $request, Organizador $organizador): RedirectResponse
    {
        $organizador->update($this->validatedData($request));

        return redirect()
            ->route('organizadores.edit', $organizador)
            ->with('success', 'El organizador se actualizó correctamente.');
    }

    public function destroy(Organizador $organizador): RedirectResponse
    {
        if ($organizador->eventos()->exists()) {
            return redirect()
                ->route('organizadores.index')
                ->with('error', 'No se puede eliminar este organizador porque tiene eventos asociados.');
        }

        $organizador->delete();

        return redirect()
            ->route('organizadores.index')
            ->with('success', 'El organizador se eliminó correctamente.');
    }

    /**
     * @return array<string, string>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'empresa' => ['required', 'string', 'max:255'],
            'telefono' => ['required', 'string', 'max:255'],
        ]);
    }
}
