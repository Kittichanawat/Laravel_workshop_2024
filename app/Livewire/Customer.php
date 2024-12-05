<?php

namespace App\Livewire;

use App\Models\RoomModel;
use App\Models\CustomerModel;
use Livewire\Component;

class Customer extends Component {
    public $customers = [];
    public $rooms = [];
    public $showModal = false;
    public $showModalDelete = false;
    public $showModalMove = false;
    public $id;
    public $name;
    public $phone;
    public $address;
    public $remark;
    public $roomId;
    public $createdAt;
    public $stayType = 'd'; 
    public $roomIdMove;

    public function mount() {
        $this->fetchData();
        $this->createdAt = date('Y-m-d');
    }
    public function fetchData() {
        $this->customers = CustomerModel::where('status', 'use')
            ->orderBy('id', 'desc')
            ->get();

        $this-> rooms = RoomModel::where('status', 'use')
            ->where('is_empty', 'yes')
            ->orderBy('name', 'desc')
            ->get();
    }
    public function openModal() {
        $this->showModal = true;
    }
    public function closeModal() {
        $this->showModal = false;
    }
    public function save() {
        if (!$this->roomId) {
            return;
        }

        $customer = new CustomerModel();
        if($this->id) {
            $customer = CustomerModel::find($this->id);
        } else {
            $customer->room_id = $this->roomId;
        }

        $room = RoomModel::find($this->roomId);
        if (!$room) {
            return;
        }

        $room->is_empty = 'no';
        $room->save();

        $price = $room->price_per_day;
        if ($this->stayType == 'm') {
            $price = $room->price_per_month;
        }

        $customer->name = $this->name;
        $customer->phone = $this->phone;
        $customer->address = $this->address;
        $customer->remark = $this->remark;
        $customer->created_at = $this->createdAt;
        $customer->status = "use";
        $customer->price = $price;
        $customer->stay_type = $this->stayType;
        $customer->save();

        $this->resetFields();
        $this->showModal = false;
        $this->fetchData();
    }

    private function resetFields() {
        $this->id = null;
        $this->name = '';
        $this->phone = '';
        $this->address = '';
        $this->remark = '';
        $this->roomId = '';
        $this->stayType = 'd';
        $this->createdAt = date('Y-m-d');
    }

    public function openModalEdit($id) {
        $this->showModal = true;
        $this->id = $id;

        $customer = CustomerModel::find($id);
        $this->name = $customer->name;
        $this->phone = $customer->phone;
        $this->address = $customer->address;
        $this->remark  = $customer->remark;
        $this->roomId = $customer->room_id;
        $this->createdAt = date('Y-m-d', strtotime($customer->created_at));
        $this->stayType = $customer->stay_type;
    }
    public function openModalDelete($id) {
        $this->showModalDelete = true;
        $this->id  = $id;

    }
    public function delete() {
        $customer = CustomerModel::find($this->id);
        $customer->status = 'delete';
        $customer->save();

        $room = RoomModel::find($customer->room_id);
        $room->is_empty = 'yes';
        $room->save();

        $this->showModalDelete = false;
        $this->fetchData();
    }
    public function closeModalDelete() {
        $this->showModalDelete = false;
    }
    public function render(){
        return view('livewire.customer');
    }
    public function openModalMove($id) {
        $this->showModalMove = true;
        $this->id = $id;
    }

    public function move() {
        $customer = CustomerModel::find($this->id);

        $room = RoomModel::find($customer->room_id);
        $room->is_empty ='yes';
        $room->save();

        $customer->room_id = $this->roomIdMove;
        $customer->save();

        $roomNew = RoomModel::find($this->roomIdMove);
        $roomNew->is_empty = 'no';
        $roomNew->save();

        $this->showModalMove = false;
        $this->fetchData();


    }

    public function closeModalMove() {
        $this->showModalMove = false;
    }
}
?>