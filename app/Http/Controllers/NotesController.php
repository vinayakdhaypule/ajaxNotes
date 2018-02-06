<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use Validator;
use Response;
use App\Notes;
use View;


class NotesController extends Controller {

   public function __construct()  {
    
      $this->middleware('auth');
    }
    

    protected $rules =
    [
        'title' => 'required|min:2',
        'notes' => 'required|min:2'
    ];

    public function index() {

        $notes = Notes::orderBy('id', 'desc')->get();
        return view('notes.index', ['notes' => $notes]);
    }

    public function create() {
        //
    }

    public function store(Request $request) {

        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $note = new Notes();
            $note->title = $request->title;
            $note->notes = $request->notes;
            $note->save();
            return response()->json($note);
        }
    }


    public function show($id) {

        $note = Notes::findOrFail($id);
        return view('note.show', ['note' => $note]);
    }


    public function edit($id) {
        //
    }

    public function update(Request $request, $id) {

        $validator = Validator::make(Input::all(), $this->rules);
        if ($validator->fails()) {
            return Response::json(array('errors' => $validator->getMessageBag()->toArray()));
        } else {
            $note = Notes::findOrFail($id);
            $note->title = $request->title;
            $note->notes = $request->notes;
            $note->save();
            return response()->json($note);
        }
    }

    public function destroy($id) {

        $note = Notes::findOrFail($id);
        $note->delete();
        return response()->json($note);
    }

}