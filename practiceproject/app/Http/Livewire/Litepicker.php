<?php

namespace App\Http\Livewire;

use App\Models\User;
use Illuminate\Console\View\Components\Alert;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Litepicker extends Component
{
    use LivewireAlert;

    public $first_name, $last_name, $email, $password;
    public $status;

    public function store()
    {
        $user = new User;
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->email = $this->email;
        $user->password = $this->password;
        $user->save();
       $this->alert('success', 'Save successfully');
    }

public function statusChange($id)
{
    $statusChange = User::find($id);
    if($statusChange->status == '0')
    {

        $statusChange->status = 1 ;
    }else{
        $statusChange->status = 0 ;
    }
    $statusChange->save();
    $this->alert('success', 'Status changed');

}


    public function render()
    {
        $userDetails = User::get();
// dd($userDetails);
        return view('livewire.litepicker', compact('userDetails'));
    }
}
