<?php

namespace App\Http\Controllers;

use App\Models\Evento;
use App\Models\Organizador;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EventoController extends Controller
{
    public function index(): View
    {
        $eventos = Evento::with('organizador')
            ->latest('fecha')
            ->paginate(10);

        return view('admin.eventos.index', compact('eventos'));
    }

    public function create(): View
    {
        $organizadores = Organizador::orderBy('nombre')->get();

        return view('admin.eventos.create', compact('organizadores'));
    }

    public function store(Request $request): RedirectResponse
    {
        $evento = Evento::create($this->validatedData($request));

        return redirect()
            ->route('eventos.edit', $evento)
            ->with('success', 'El evento se creó correctamente.');
    }

    public function edit(Evento $evento): View
    {
        $organizadores = Organizador::orderBy('nombre')->get();

        return view('admin.eventos.edit', compact('evento', 'organizadores'));
    }

    public function update(Request $request, Evento $evento): RedirectResponse
    {
        $evento->update($this->validatedData($request));

        return redirect()
            ->route('eventos.edit', $evento)
            ->with('success', 'El evento se actualizó correctamente.');
    }

    public function destroy(Evento $evento): RedirectResponse
    {
        $evento->delete();

        return redirect()
            ->route('eventos.index')
            ->with('success', 'El evento se eliminó correctamente.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validatedData(Request $request): array
    {
        return $request->validate([
            'id_organizador' => ['required', 'integer', 'exists:organizadores,id_organizador'],
            'nombre' => ['required', 'string', 'max:255'],
            'fecha' => ['required', 'date'],
            'lugar' => ['required', 'string', 'max:255'],
            'presupuesto' => ['required', 'integer', 'min:0'],
        ]);
    }
}
