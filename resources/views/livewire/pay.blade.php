<div>
    <div class="content-header">
        <div>
            <div>บันทึกค่าใช้จ่าย</div>
        </div>
    </div>
    <div class="content-body">
        <div class="flex">
            <button class="btn-info mr-2" wire:click="openModalPayLog">
                <i class="fa fa-plus mr-2"></i>
                เพิ่มค่าใช้จ่าย
            </button>
            <button class="btn-info" wire:click="openModalPay">
                รายการค่าใช้จ่าย
            </button>
        </div>

        <table class="table mt-3">
            <thead>
                <tr>
                 
                    <th class="text-left " width="100px">วันที่</th>
                    <th class="text-left" width="300px">รายการ</th>
                    <th class="text-left">หมายเหตุ</th>
                    <th class="text-right" width="100px">ยอดเงิน</th>
                    <th width="130px"></th>
                </tr>
            </thead>
             <tbody>
                @foreach ($payLogs as $payLog)
                <tr>
                    <td>{{date('d/m/Y', strtotime($payLog->pay_date))}}</td>
                    <td>{{$payLog->pay->name}}
                     @if ($payLog->status == 'delete')
                        <span class="text-red-500 ml-5">*** ถูกลบ ***</span>
                     @endif
                    </td>
                    <td>{{$payLog->pay->remark}}</td>
                    <td class="text-right">{{number_format($payLog->amount)}}</td>
                    <td>
                       <button class="btn-edit" wire:click="openModalPayLogEdit({{$payLog->id}})">
                        <i class="fa fa-pencil mr-2"></i>
                       </button> 
                       @if ($payLog->status == 'use')
                       <button class="btn-delete " wire:click="openModalPayLogDelete({{$payLog->id}})">
                            <i class="fa fa-times mr-2"></i>
                       </button>
                       @endif

                       @if ($payLog->status == 'delete')
                       <button class="btn-edit" wire:click="openModalPayLogRestore({{$payLog->id}})">
                            <i class="fa-solid  fa-chevron-left mr-2"></i>
                       </button>
                       @endif
                    </td>
                </tr>
                @endforeach
             </tbody>
        </table>
    </div>
</div>