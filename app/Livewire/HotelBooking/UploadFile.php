<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Storage;
use App\Models\HotelBooking\RoomBookingFile;

class UploadFile extends Component
{
    use WithFileUploads;

    public $roomBooking;
    public $file;

    public function addItem()
    {
        $this->validate([
            'file' => 'file|mimes:png,jpg,pdf|max:1024', // 1MB Max
        ]);

        if($this->roomBooking){
            $this->file->store('ionline/hotel_booking/booking_files',['disk' => 'gcs']);
            $roomBookingFile = new RoomBookingFile();
            $roomBookingFile->file = "ionline/hotel_booking/booking_files/" . $this->file->hashName();
            $roomBookingFile->name = $this->file->hashName();
            $roomBookingFile->room_booking_id = $this->roomBooking->id;
            $roomBookingFile->save();
            $this->roomBooking->refresh();
        }     
    }

    public function deleteItem($file){
        Storage::delete($file['file']);
        if($this->roomBooking){
            $file = RoomBookingFile::where('file',$file['file'])->first();
            $file->delete();
            $this->roomBooking->refresh();
        }
    }

    public function render()
    {
        return view('livewire.hotel-booking.upload-file');
    }
}
