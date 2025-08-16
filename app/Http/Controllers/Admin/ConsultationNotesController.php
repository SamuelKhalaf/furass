<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Consultation;
use App\Models\ConsultationNotes;
use Illuminate\Http\Request;

class ConsultationNotesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = ConsultationNotes::with('consultation')->paginate(10);
        return view('admin.consultation_notes.index', compact('notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $consultations = Consultation::all();
        return view('admin.consultation_notes.create', compact('consultations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'notes' => 'required|string',
        ]);
        ConsultationNotes::create($validated);
        return redirect()->route('consultation-notes.index')->with('success', 'Consultation note created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $note = ConsultationNotes::with('consultation')->findOrFail($id);
        return view('admin.consultation_notes.show', compact('note'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $note = ConsultationNotes::findOrFail($id);
        $consultations = Consultation::all();
        return view('admin.consultation_notes.edit', compact('note', 'consultations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $note = ConsultationNotes::findOrFail($id);
        $validated = $request->validate([
            'consultation_id' => 'required|exists:consultations,id',
            'notes' => 'required|string',
        ]);
        $note->update($validated);
        return redirect()->route('consultation-notes.index')->with('success', 'Consultation note updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $note = ConsultationNotes::findOrFail($id);
        $note->delete();
        return redirect()->route('consultation-notes.index')->with('success', 'Consultation note deleted successfully.');
    }
}
