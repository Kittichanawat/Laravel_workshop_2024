@props(['title','text', 'clickConfirm', 'clickCancel'])

<x-modal wire:model="showModalDelete" maxWidth="xl" title="{{$title}}">
    <div class="p-5 text-center text-xl">
        <div class="text-8xl text-orange-500 mb-5">
            <i class="fa-solid fa-question"></i>
        </div>
        <div class="text-4xl font-bold">{{$title}}</div>
        <div class="text-2xl mt-3">{{$text}}</div>
    </div>
    <div class="mt-5 text-center pb-5">
        <button class="btn btn-success mr-2 mb-2" wire:click="{{$clickConfirm}}">
            <i class="fa-solid fa-check me-2"></i>
            ยืนยัน
        </button>
        <button class="btn btn-secondary" wire:click="{{$clickCancel}}">
            <i class="fa-solid fa-xmark me-2"></i>
            ยกเลิก
        </button>
        
    </div>
</x-modal>