<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Note;
use App\Http\Traits\sendMessage;
use App\Http\Resources\Note AS NoteResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    use sendMessage;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $notes = Note::where('user_id', Auth::guard('api')->id())->get();

        if(!count($notes))
            return $this->sendMessageResponse('There is no note!');

        return $this->sendResponse(NoteResource::collection($notes), 'All Notes, length: ' . count($notes));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required'
        ]);

        if($validator->fails())
            return $this->sendError('Something went wrong!', $validator->errors());

        $value = $request->all();
        $value['user_id'] = Auth::guard('api')->id();
        Note::create($value);

        return $this->sendMessageResponse('Note created successful!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $note = Note::find($id);

        if(is_null($note)) {
            return $this->sendError('Note not found!', '', 404);
        } else if($note->user_id != Auth::guard('api')->id()) {
            return $this->sendError('This note is unavailable!', '', 401);
        } else return $this->sendResponse(new NoteResource($note), 'Note found successful!');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $note = Note::find($id);

        if(is_null($note))
            return $this->sendError('Note not found!', '', 404);

        if($note->user_id != Auth::guard('api')->id())
            return $this->sendError('You can edit on this note!', '', 401);

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'content' => 'required',
        ]);

        if($validator->fails())
            return $this->sendError('Something went wrong!', $validator->errors());

        $note->update($request->all());

        return $this->sendMessageResponse('Note updated successful!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $note = Note::find($id);

        if(is_null($note)) {
            return $this->sendError('Note not found', '', 404);
        } else if($note->user_id != Auth::guard('api')->id()) {
            return $this->sendError('You can delete on this note!', '', 401);
        } else $note->delete();

        return $this->sendMessageResponse('Note Deleted successful!');
    }
}
