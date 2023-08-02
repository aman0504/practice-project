<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;

class ChatApp extends Component
{
    // ** steps to make chat.....
    // 1. so firstly register 2-3 users.      done...
    // 2. show all users except loggedin user.  done....
    //3. when i click on 1 user , get its id and pass in receiver_id.   done...
    //4. get receiver_id and message and show in screen.
    // same for sender 4th step.
    //jine msg kita , jinu msg kita sirf ona dona de msg get karne a and shoe karne a   done.....
    // 5. i am using spatie to manage(save) images, videos, voicemsg
    // 6. how to use and save emoji's


    use WithFileUploads;
    public $message, $sender_id, $receiver_id, $read, $image;
    public $messages, $senderUserId, $selectedUserId;
    public $selectedUserChats;

    public function mount()
    {
        $this->senderUserId = auth()->user()->id;

        // $user= Message::where('sender_id', $this->senderUserId)->with('sender')->first();

        // dd($user->sender->name);

    }

    public function getId($id)
    {
        $this->selectedUserId = $id;

        $this->loadMessages();
    }


    public function loadMessages()
    {

        $this->selectedUserChats = Message::where(function ($query) {
            $query->where('sender_id', $this->senderUserId)

                ->where('receiver_id', $this->selectedUserId);
        })
            ->orWhere(function ($query) {
                $query->where('sender_id', $this->selectedUserId)->where('receiver_id', $this->senderUserId);
            })->orderBy('created_at', 'ASC')->with('sender')->with('reciever')->get();

        // dd($this->selectedUserChats);
    }

    public function store()
    {
        $messages = new Message;
        $messages->message = $this->message;
        $messages->sender_id = $this->senderUserId;
        $messages->receiver_id =  $this->selectedUserId;
        // $messages->image = $this->image;
        // $image = $messages->addMedia($this->image->getRealPath())->toMediaCollection('images');
        // dd($image);
        $messages->save();
        $this->message = ''; // Clear the message input field


    }


    public function render()
    {
        $users = User::where('id', '!=', auth()->id())->get();

        return view('livewire.chat-app', compact('users'));
    }
}
