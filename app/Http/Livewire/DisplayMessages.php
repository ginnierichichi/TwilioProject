<?php

namespace App\Http\Livewire;

use App\Models\Message;
use Livewire\Component;
use Livewire\WithPagination;

class DisplayMessages extends Component
{
    use WithPagination;



    public function render()
    {
        return view('livewire.display-messages', [
            'messages' => Message::with('addressBook')->paginate('10'),
        ]);
    }
}
