<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\View\View;

class VisitorController extends Controller
{
    public function index(Request $request): View
    {
        $query = Visitor::query()
            ->search($request->input('search'))
            ->dateRange($request->input('range'));

        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->input('date'));
        }

        if ($request->input('status') === 'in') {
            $query->currentlyIn();
        } elseif ($request->input('status') === 'out') {
            $query->checkedOut();
        }

        $visitors = $query->orderByDesc('time_in')->paginate(10)->withQueryString();

        $today = Carbon::today();

        $stats = [
            'today' => Visitor::whereDate('visit_date', $today)->count(),
            'currently_in' => Visitor::currentlyIn()->count(),
            'this_week' => Visitor::whereBetween('visit_date', [$today->copy()->startOfWeek(), $today->copy()->endOfWeek()])->count(),
        ];

        return view('visitors.index', [
            'visitors' => $visitors,
            'stats' => $stats,
            'filters' => $request->only(['search', 'range', 'date', 'status']),
        ]);
    }

    // ✅ BAGO: Ipakita ang buong detalye ng bisita (para sa View button)
    public function show(Visitor $visitor)
    {
        return response()->json($visitor);
    }

    // ✅ BAGO: Kunin ang datos para sa Edit form
    public function edit(Visitor $visitor)
    {
        return response()->json($visitor);
    }

    // ✅ BAGO: I-update ang talaan ng bisita
    public function update(Request $request, Visitor $visitor): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_no' => ['nullable', 'string', 'max:20'],
            'id_type' => ['nullable', 'string', 'max:50'],
            'id_number' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'person_to_visit' => ['required', 'string', 'max:255'],
            'purpose' => ['required', 'string', 'max:255'],
        ]);

        $visitor->update($validated);

        return back()->with('success', 'Visitor information updated successfully.');
    }

    // ✅ Inayos: Isinama ang status kapag nag-checkout
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'contact_no' => ['nullable', 'string', 'max:20'],
            'id_type' => ['nullable', 'string', 'max:50'],
            'id_number' => ['nullable', 'string', 'max:50'],
            'address' => ['required', 'string', 'max:255'],
            'person_to_visit' => ['required', 'string', 'max:255'],
            'purpose' => ['required', 'string', 'max:255'],
        ]);

        $now = Carbon::now();

        Visitor::create([
            ...$validated,
            'visit_date' => $now->toDateString(),
            'time_in' => $now,
            'status' => 'Checked In', // ✅ Dagdag default status
        ]);

        return back()->with('success', 'Visitor added successfully.');
    }

    // ✅ Inayos: I-update din ang status kapag nag-checkout
    public function checkout(Visitor $visitor): RedirectResponse
    {
        if (! $visitor->time_out) {
            $visitor->update([
                'time_out' => Carbon::now(),
                'status' => 'Checked Out'
            ]);
        }

        return back()->with('success', 'Check-out time has been recorded successfully.');
    }

    public function destroy(Visitor $visitor): RedirectResponse
    {
        $visitor->delete();

        return back()->with('success', 'Visitor deleted successfully.');
    }

    public function print(Request $request): View
    {
        $query = Visitor::query()
            ->search($request->input('search'))
            ->dateRange($request->input('range'));

        if ($request->filled('date')) {
            $query->whereDate('visit_date', $request->input('date'));
        }

        if ($request->input('status') === 'in') {
            $query->currentlyIn();
        } elseif ($request->input('status') === 'out') {
            $query->checkedOut();
        }

        $visitors = $query->orderByDesc('time_in')->get();

        return view('visitors.print', [
            'visitors' => $visitors,
            'filters' => $request->only(['search', 'range', 'date', 'status']),
        ]);
    }

    public function report(Request $request): View
    {
        $period = $request->input('period', 'daily');
        $today = Carbon::today();

        if ($period === 'weekly') {
            $start = $today->copy()->startOfWeek();
            $end = $today->copy()->endOfWeek();
        } else {
            $start = $today->copy();
            $end = $today->copy();
        }

        $visitors = Visitor::whereBetween('visit_date', [$start, $end])->get();

        $perDay = $visitors->groupBy(fn (Visitor $v) => $v->visit_date->toDateString())
            ->map(fn ($group) => [
                'count' => $group->count(),
                'checked_out' => $group->whereNotNull('time_out')->count(),
                'still_in' => $group->whereNull('time_out')->count(),
            ]);

        $topHosts = $visitors->groupBy('person_to_visit')
            ->map(fn ($group) => $group->count())
            ->sortDesc()
            ->take(5);

        return view('visitors.report', [
            'period' => $period,
            'start' => $start,
            'end' => $end,
            'total' => $visitors->count(),
            'perDay' => $perDay,
            'topHosts' => $topHosts,
        ]);
    }
}