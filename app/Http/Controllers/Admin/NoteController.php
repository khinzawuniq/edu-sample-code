<?php

namespace App\Http\Controllers\Admin;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\User;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $last_note = Note::orderBy('id','desc')->first();

        $note_id = $last_note ? $last_note->id+1 : 1;

        $note = new Note();
        $note->note_title = 'Note '.$note_id;
        $note->note_description = $request->note_description;
        $note->created_by = Auth::id();
        $note->course_id = $request->course_id;
        $note->save();

        $short_note = Str::limit($note->note_description, 30, $end='...');

        return response()->json([
            'status' => 200,
            'note' => $note,
            'short_note' => $short_note,
        ]);
    }
    
    // public function store(Request $request)
    // {
    //     $this->validate($request, [
    //         'note_description' => 'required',
    //     ]);
        
    //     $input = $request->except(['_token']);
    //     $input['created_by'] = Auth::id();

    //     $note = Note::create($input);

    //     flash('Exam created successful!')->success()->important();
    //     return redirect('/courses/detail/'.$note->course->slug);
    // }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Note $note)
    {
        // $last_note = Note::orderBy('id','desc')->first();

        // $note_id = $last_note ? $last_note->id+1 : 1;

        // $note = new Note();
        // $note->note_title = 'Note '.$note_id;
        $note->note_description = $request->note_description;
        $note->save();

        $short_note = Str::limit($note->note_description, 30, $end='...');

        return response()->json([
            'status' => 200,
            'note' => $note,
            'short_note' => $short_note,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy(Note $note)
    {
        $note->delete();

        return response()->json([
            'status' => 200,
        ]);
    }
}
