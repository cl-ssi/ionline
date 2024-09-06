<?php

namespace App\Livewire\HotelBooking;

use Livewire\Component;
use Livewire\WithFileUploads;

use Illuminate\Support\Facades\Storage;
use App\Models\HotelBooking\HotelImage;
use App\Models\HotelBooking\RoomImage;

class UploadImagen extends Component
{
    use WithFileUploads;

    public $hotel;
    public $room;
    public $imgFile;

    public function addItem()
    {
        $this->validate([
            'imgFile' => 'image|max:1024', // 1MB Max
        ]);

        if($this->hotel){
            $this->imgFile->store('ionline/hotel_booking/hotel_images',['disk' => 'gcs']);
            $HotelImage = new HotelImage();
            $HotelImage->file = "ionline/hotel_booking/hotel_images/" . $this->imgFile->hashName();
            $HotelImage->name = $this->imgFile->hashName();
            $HotelImage->hotel_id = $this->hotel->id;
            $HotelImage->save();
            $this->hotel->refresh();
        }

        if($this->room){
            $this->imgFile->store('ionline/hotel_booking/room_images',['disk' => 'gcs']);
            $roomImage = new RoomImage();
            $roomImage->file = "ionline/hotel_booking/room_images/" . $this->imgFile->hashName();
            $roomImage->name = $this->imgFile->hashName();
            $roomImage->room_id = $this->room->id;
            $roomImage->save();
            $this->room->refresh();
        }
        
    }

    public function deleteItem($file){
        Storage::delete($file['file']);
        if($this->hotel){
            $file = HotelImage::where('file',$file['file'])->first();
            $file->delete();
            $this->hotel->refresh();
        }
        if($this->room){
            $file = RoomImage::where('file',$file['file'])->first();
            $file->delete();
            $this->room->refresh();
        }
    }

    public function render()
    {
        return view('livewire.hotel-booking.upload-imagen');
    }
}
