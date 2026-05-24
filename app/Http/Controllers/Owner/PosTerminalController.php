<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\PosTerminal;
use App\Models\Restaurant;
use Illuminate\Http\Request;

class PosTerminalController extends Controller
{
    public function index()
    {
        $restaurantId = session('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $terminals = PosTerminal::with(['restaurant', 'branch'])
            ->where('restaurant_id', $restaurantId)
            ->latest()
            ->get();

        return view('owner.pos-terminals.index', compact('terminals'));
    }

    public function create()
    {
        $restaurantId = session('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $restaurant = Restaurant::find($restaurantId);

        if (! $restaurant) {
            return redirect()->route('owner.login');
        }

        $branches = Branch::where('restaurant_id', $restaurantId)
            ->orderBy('name')
            ->get();

        return view('owner.pos-terminals.create', compact('restaurant', 'branches'));
    }

    public function store(Request $request)
    {
        $restaurantId = session('owner_restaurant_id');

        if (! $restaurantId) {
            return redirect()->route('owner.login');
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'branch_id' => ['nullable', 'exists:branches,id'],
        ]);

        if ($request->branch_id) {
            Branch::where('restaurant_id', $restaurantId)
                ->where('id', $request->branch_id)
                ->firstOrFail();
        }

        PosTerminal::create([
            'restaurant_id' => $restaurantId,
            'branch_id' => $request->branch_id ?: null,
            'name' => $request->name,
            'activation_code' => $this->generateActivationCode(),
            'is_active' => true,
        ]);

        return redirect()
            ->route('owner.pos-terminals.index')
            ->with('success', 'Terminal yaradıldı.');
    }

    public function edit(PosTerminal $pos_terminal)
    {
        $this->checkTerminal($pos_terminal);

        $restaurantId = session('owner_restaurant_id');

        $branches = Branch::where('restaurant_id', $restaurantId)
            ->orderBy('name')
            ->get();

        return view('owner.pos-terminals.edit', [
            'terminal' => $pos_terminal,
            'branches' => $branches,
        ]);
    }

    public function update(Request $request, PosTerminal $pos_terminal)
    {
        $this->checkTerminal($pos_terminal);

        $restaurantId = session('owner_restaurant_id');

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'branch_id' => ['nullable', 'exists:branches,id'],
        ]);

        if ($request->branch_id) {
            Branch::where('restaurant_id', $restaurantId)
                ->where('id', $request->branch_id)
                ->firstOrFail();
        }

        $pos_terminal->update([
            'name' => $request->name,
            'branch_id' => $request->branch_id ?: null,
        ]);

        return redirect()
            ->route('owner.pos-terminals.index')
            ->with('success', 'Terminal yeniləndi.');
    }

    public function destroy(PosTerminal $pos_terminal)
    {
        $this->checkTerminal($pos_terminal);

        $pos_terminal->delete();

        return back()->with('success', 'Terminal silindi.');
    }

    public function toggle(PosTerminal $pos_terminal)
    {
        $this->checkTerminal($pos_terminal);

        $pos_terminal->update([
            'is_active' => ! $pos_terminal->is_active,
        ]);

        return back()->with('success', 'Status dəyişdirildi.');
    }

    public function reset(PosTerminal $pos_terminal)
    {
        $this->checkTerminal($pos_terminal);

        $pos_terminal->update([
            'activation_code' => $this->generateActivationCode(),
            'device_token' => null,
            'activated_at' => null,
            'last_used_at' => null,
        ]);

        return back()->with('success', 'Terminal sıfırlandı.');
    }

    private function generateActivationCode(): string
    {
        do {
            $code = 'NP-' . random_int(100000, 999999);
        } while (PosTerminal::where('activation_code', $code)->exists());

        return $code;
    }

    private function checkTerminal(PosTerminal $terminal): void
    {
        $restaurantId = session('owner_restaurant_id');

        if (! $restaurantId) {
            abort(403);
        }

        abort_if($terminal->restaurant_id != $restaurantId, 403);
    }
}
