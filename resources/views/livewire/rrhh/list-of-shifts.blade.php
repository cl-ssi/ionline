
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


    @if(isset($staffInShift)&&count($staffInShift)>0&&$staffInShift!="")
        @foreach($staffInShift as $sis)
        {{-- sizeof($sis->days->where('day','>=',$mInit[0])->where('day','<',$mEnd[0])) --}}
        @if( sizeof($sis->days->where('day','>=',$mInit[0])->where('day','<',$mEnd[0])) > 0 )  
            <tr>
                <td class="bless br cellbutton" >
                    <i class="fa fa-close deleteButton" href="/"></i>  
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
                               @livewire('rrhh.change-shift-day-status',['shiftDay'=>$d->first()],key($d->first()->id) )
                            @else
                               
                               <i data-toggle="modal" data-target="#newDatModal"  data-keyboard= "false" data-backdrop= "static"  style="color:green;font-weight: bold;font-size:20px" class="fa fa-plus btnShiftDay">
                                </i>
                              
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


