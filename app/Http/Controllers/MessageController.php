<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Carbon;
use App\Events\MessageSent;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = Message::paginate(20);

        return view('backend.message.index')->with('messages', $messages);
    }

    /**
     *  Get all unread messages.
     * 
     *  @return \Illuminate\Http\Response
     */
    public function messageFive()
    {
        $message = Message::whereNull('read_at')->limit(5)->get();

        return response()->json($message);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = Message::create($request->all());

        $data = array();

        $data['url'] = route('message.show', $message->id);
        $data['date'] = $message->created_at->format('F d, Y h:i A');
        $data['name'] = $message->name;
        $data['email'] = $message->email;
        $data['phone'] = $message->phone;
        $data['message'] = $message->message;
        $data['subject'] = $message->subject;
        $data['photo'] = Auth()->user()->photo;

        event(new MessageSent($data));

        exit();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $message = Message::findOrFail($id);

        $message->read_at = Carbon::now();

        $message->save();

        return view('backend.message.show')->with('message', $message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $message = Message::findOrFail($id);

        $status = $message->delete();

        if ($status) {
            request()->session()->flash('success', 'Mensagem deletada com sucesso.');
        } else {
            request()->session()->flash('error', 'Ocorreu um erro ao deletar essa mensagem. Por favor, tente novamente.');
        }
        
        return back();
    }
}
