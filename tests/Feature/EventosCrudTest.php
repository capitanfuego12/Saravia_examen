<?php

namespace Tests\Feature;

use App\Models\Evento;
use App\Models\Organizador;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EventosCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_event_management_requires_authentication(): void
    {
        $this->get(route('eventos.index'))
            ->assertRedirect(route('login'));
    }

    public function test_create_form_requires_an_existing_organizer(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('eventos.create'))
            ->assertOk()
            ->assertSee('No hay organizadores registrados.')
            ->assertSee('Primero agrega un organizador');
    }

    public function test_authenticated_admin_can_create_update_and_delete_an_event(): void
    {
        $this->actingAs(User::factory()->create());
        $organizador = Organizador::create([
            'nombre' => 'Organizador original',
            'empresa' => 'Empresa original',
            'telefono' => '5551234',
        ]);

        $this->get(route('eventos.index'))
            ->assertOk()
            ->assertSee('Todavía no hay eventos registrados.');

        $this->post(route('eventos.store'), [
            'id_organizador' => $organizador->id_organizador,
            'nombre' => 'Evento para actualizar',
            'fecha' => '2026-12-15',
            'lugar' => 'Auditorio',
            'presupuesto' => 5000,
        ])->assertRedirect();

        $eventoActualizar = Evento::where('nombre', 'Evento para actualizar')->firstOrFail();

        $this->assertDatabaseHas('eventos', [
            'id_evento' => $eventoActualizar->id_evento,
            'nombre' => 'Evento para actualizar',
            'id_organizador' => $organizador->id_organizador,
        ]);

        $this->post(route('eventos.store'), [
            'id_organizador' => $organizador->id_organizador,
            'nombre' => 'Evento para eliminar',
            'fecha' => '2026-12-20',
            'lugar' => 'Teatro',
            'presupuesto' => 3000,
        ])->assertRedirect();

        $eventoEliminar = Evento::where('nombre', 'Evento para eliminar')->firstOrFail();

        $this->get(route('eventos.index'))
            ->assertOk()
            ->assertSee('Evento para actualizar')
            ->assertSee('Evento para eliminar')
            ->assertSee('Organizador original');

        $this->put(route('eventos.update', $eventoActualizar), [
            'id_organizador' => $organizador->id_organizador,
            'nombre' => 'Evento actualizado',
            'fecha' => '2027-01-20',
            'lugar' => 'Centro de convenciones',
            'presupuesto' => 7500,
        ])->assertRedirect(route('eventos.edit', $eventoActualizar));

        $this->assertDatabaseHas('eventos', [
            'id_evento' => $eventoActualizar->id_evento,
            'nombre' => 'Evento actualizado',
            'lugar' => 'Centro de convenciones',
            'presupuesto' => 7500,
        ]);

        $this->delete(route('eventos.destroy', $eventoEliminar))
            ->assertRedirect(route('eventos.index'));

        $this->assertDatabaseMissing('eventos', [
            'id_evento' => $eventoEliminar->id_evento,
        ]);

        $this->assertDatabaseHas('eventos', [
            'id_evento' => $eventoActualizar->id_evento,
            'nombre' => 'Evento actualizado',
        ]);
    }

    public function test_event_cannot_be_created_with_a_nonexistent_organizer(): void
    {
        $this->actingAs(User::factory()->create())
            ->post(route('eventos.store'), [
                'id_organizador' => 9999,
                'nombre' => 'Evento inválido',
                'fecha' => '2026-12-15',
                'lugar' => 'Auditorio',
                'presupuesto' => 5000,
            ])
            ->assertSessionHasErrors('id_organizador');

        $this->assertDatabaseCount('eventos', 0);
    }
}
