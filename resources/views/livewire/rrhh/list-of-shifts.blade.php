<style type="text/css">
    
.menu {
    display: none;
}

figure:active .menu,
figure:focus .menu {
    display: visible;
}
</style>
<div>
   <div wire:loading>
              <i class="fas fa-spinner fa-pulse"></i>
        </div>

    @php
        $mInit = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-01");  
        $mInit = explode(" ",$mInit);  
                       
        $mEnd = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-31");  
        $mEnd = explode(" ",$mEnd);  

    @endphp

     @livewire( 'rrhh.delete-shift',['startdate'=>$mInit[0],'enddate'=> $mEnd[0] ] ) 
     @livewire('rrhh.add-day-of-shift-modal')
    @if(isset($staffInShift)&&count($staffInShift)>0&&$staffInShift!="")
        @foreach($staffInShift as $sis)
        {{-- sizeof($sis->days->where('day','>=',$mInit[0])->where('day','<',$mEnd[0])) --}}
        @if( sizeof($sis->days->where('day','>=',$mInit[0])->where('day','<',$mEnd[0])) > 0 )  
            <tr>
                <td class="bless br cellbutton" >
                    
                    @livewire( 'rrhh.delete-shift-button',['actuallyShiftUserDay'=>$sis])

                    @livewire( 'rrhh.see-shift-control-form', ['usr'=>$sis->user, 'actuallyYears'=>$actuallyYear,'actuallyMonth'=>$actuallyMonth], key($loop->index) )

                  {{ $sis->user->runFormat()}} - {{$sis->user->name}} {{$sis->user->fathers_family}} 
      
                </td>
                @for($j = 1; $j <= $days; $j++) 
                    @php
                        $date = \Carbon\Carbon::createFromFormat('Y-m-d',  $actuallyYear."-".$actuallyMonth."-".$j);  
                        $date =explode(" ",$date);
                        $d = $sis->days->where('day',$date[0]);
                       
                       
                    @endphp
                    <td class="bbd day "  style="text-align:center;width:54px;height:54px">
                            @if( isset($d) && count($d) )  
                                @foreach($d as $dd)
                                   

                                    @livewire('rrhh.change-shift-day-status',['shiftDay'=>$dd,'loop'=>$loop->index],key($dd->id) )

                                @endforeach
                            @else
                                @livewire('rrhh.add-day-of-shift-button',['shiftUser'=>$sis,'day'=>$date])
                            @endif
                        
                    </td>
                @endfor    
            </tr>   
        @endif    
        @endforeach
        
        @else                           
            <td style="text-align:  center;" colspan="{{$days}}">SIN PERSONAL ASIGNADO</td>
        @endif

</div>



