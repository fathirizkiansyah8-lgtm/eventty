<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use App\Models\TeamRegistration;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ParticipantsController extends Controller
{
    public function index(Request $request): View
    {
        $events = Event::with('category')->orderBy('date', 'desc')->get();

        $query = EventParticipant::with(['user', 'event', 'event.category']);

        $selectedEvent  = null;
        $isCompetition  = false;
        $teamRegistrations = collect();

        if ($request->filled('event_id')) {
            $query->where('event_id', $request->event_id);
            $selectedEvent = Event::with('category')->find($request->event_id);
            $isCompetition = $selectedEvent && $selectedEvent->isCompetition();

            // Jika event competition, ambil data tim
            if ($isCompetition) {
                $teamRegistrations = TeamRegistration::with(['captain'])
                    ->where('event_id', $request->event_id)
                    ->orderBy('created_at')
                    ->get();
            }
        }

        if ($request->filled('status')) {
            $query->where('attendance_status', $request->status);
        }

        if ($request->filled('search')) {
            $s = $request->search;
            $query->whereHas('user', function ($q) use ($s) {
                $q->where('name', 'like', "%{$s}%")
                  ->orWhere('nis', 'like', "%{$s}%")
                  ->orWhere('class', 'like', "%{$s}%");
            });
        }

        $participants      = $query->orderBy('created_at', 'desc')->paginate(15)->withQueryString();
        $totalParticipants = EventParticipant::count();

        return view('admin.participants', compact(
            'participants', 'events', 'totalParticipants',
            'selectedEvent', 'isCompetition', 'teamRegistrations'
        ));
    }
}
