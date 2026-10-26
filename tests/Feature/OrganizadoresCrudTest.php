<?php

namespace Tests\Feature;

use App\Models\Evento;
use App\Models\Organizador;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganizadoresCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_organizer_management_requires_authentication(): void
    {
        $this->get(route('organizadores.index'))
            ->assertRedirect(route('login'));
    }

    public function test_authenticated_admin_can_create_update_and_delete_an_organizer(): void
    {
        $this->actingAs(User::factory()->create())
            ->get(route('organizadores.index'))
            ->assertOk()
            ->assertSee('Todavía no hay organizadores registrados.');

        $this->post(route('organizadores.store'), [
            'nombre' => 'María López',
            'empresa' => 'Eventos del Norte',
            'telefono' => '5551234567',
        ])->assertRedirect();

        $organizador = Organizador::firstOrFail();

        $this->assertDatabaseHas('organizadores', [
            'id_organizador' => $organizador->id_organizador,
            'nombre' => 'María López',
        ]);

        $this->get(route('organizadores.index'))
            ->assertOk()
            ->assertSee('María López')
            ->assertSee('Eventos del Norte')
            ->assertSee('5551234567');

        $this->put(route('organizadores.update', $organizador), [
            'nombre' => 'María López actualizada',
            'empresa' => 'Eventos del Sur',
            'telefono' => '5559876543',
        ])->assertRedirect(route('organizadores.edit', $organizador));

        $this->assertDatabaseHas('organizadores', [
            'id_organizador' => $organizador->id_organizador,
            'nombre' => 'María López actualizada',
            'empresa' => 'Eventos del Sur',
            'telefono' => '5559876543',
        ]);

        $this->delete(route('organizadores.destroy', $organizador))
            ->assertRedirect(route('organizadores.index'));

        $this->assertDatabaseMissing('organizadores', [
            'id_organizador' => $organizador->id_organizador,
        ]);
    }

    public function test_organizer_with_events_cannot_be_deleted(): void
    {
        $this->actingAs(User::factory()->create());

        $organizador = Organizador::create([
            'nombre' => 'Organizador asociado',
            'empresa' => 'Empresa',
            'telefono' => '5551234',
        ]);

        Evento::create([
            'id_organizador' => $organizador->id_organizador,
            'nombre' => 'Evento asociado',
            'fecha' => '2026-12-15',
            'lugar' => 'Auditorio',
            'presupuesto' => 5000,
        ]);

        $this->delete(route('organizadores.destroy', $organizador))
            ->assertRedirect(route('organizadores.index'))
            ->assertSessionHas('error');

        $this->assertDatabaseHas('organizadores', [
            'id_organizador' => $organizador->id_organizador,
        ]);
    }
}
